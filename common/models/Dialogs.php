<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dialogs".
 *
 * @property int $id
 * @property int $user_one
 * @property int $user_two
 * @property string $date
 *
 * @property User $userOne
 * @property User $userTwo
 * @property Messages[] $messages
 */
class Dialogs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dialogs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_one', 'user_two'], 'required'],
            [['user_one', 'user_two'], 'integer'],
            [['date'], 'safe'],
            [['user_one'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_one' => 'id']],
            [['user_two'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_two' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_one' => Yii::t('main', 'Пользователь #1'),
            'user_two' => Yii::t('main', 'Пользователь #2'),
            'date' => Yii::t('main', 'Дата'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserOne()
    {
        return $this->hasOne(User::className(), ['id' => 'user_one']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTwo()
    {
        return $this->hasOne(User::className(), ['id' => 'user_two']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::className(), ['dialog_id' => 'id']);
    }

    public static function getDialogsByUser($user_id)
    {
        return self::find()
            ->where(['user_one' => $user_id])
            ->orWhere(['user_two' => $user_id])
            ->viaTable('messages', ['id' => 'message_id'])
            ->innerJoin('messages msg', 'msg.dialog_id = dialogs.id')
            ->orderBy(['msg.id' => SORT_DESC])
            ->all();
    }

    public function checkDialog($user_one, $user_two)
    {
        if ($user_one == $user_two) {
            return false;
        }

        $dialog = self::find()
            ->where(['user_one' => $user_one, 'user_two' => $user_two])
            ->orWhere(['user_one' => $user_two, 'user_two' => $user_one])
            ->one();

        if (!empty($dialog)) {
            return $dialog;
        }

        return false;
    }

    public static function getDialogByUser($user_one, $user_two)
    {
        $dialog = self::checkDialog($user_one, $user_two);

        if (!empty($dialog)) {
            return $dialog;
        }

        $dialog = new Dialogs();
        $dialog->user_one = $user_one;
        $dialog->user_two = $user_two;

        if ($dialog->save()) {
            return $dialog;
        }

        return false;
    }

    public static function getMessagesById($id)
    {
        $dialog = self::find()
            ->where(['id' => $id, 'user_one' => Yii::$app->user->id])
            ->orWhere(['id' => $id, 'user_two' => Yii::$app->user->id])
            ->one();

        if (!empty($dialog)) {
            $messages = Messages::find()
                ->where(['dialog_id' => $dialog->id])
                ->orderBy(['id' => SORT_ASC])
                ->limit(100)
                ->all();

            foreach ($messages AS $message) {
                if ($message->user_id != Yii::$app->user->id && $message->seen == Messages::SEEN_NO) {
                    $message->seen = Messages::SEEN_YES;
                    $message->save();
                }
            }

            return $messages;
        }

        return false;
    }
}
