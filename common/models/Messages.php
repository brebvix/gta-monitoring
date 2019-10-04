<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property int $user_id
 * @property int $dialog_id
 * @property string $message
 * @property string $date
 * @property int $seen
 *
 * @property Dialogs $dialog
 * @property User $user
 */
class Messages extends \yii\db\ActiveRecord
{
    const SEEN_NO = 0;
    const SEEN_YES = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'dialog_id', 'message'], 'required'],
            [['user_id', 'dialog_id', 'seen'], 'integer'],
            [['message'], 'string'],
            [['date'], 'safe'],
            [['dialog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dialogs::className(), 'targetAttribute' => ['dialog_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('main', 'Пользователь'),
            'dialog_id' => Yii::t('main', 'Диалог'),
            'message' => Yii::t('main', 'Сообщение'),
            'date' => Yii::t('main', 'Дата'),
            'seen' => Yii::t('main', 'Просмотрено'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDialog()
    {
        return $this->hasOne(Dialogs::className(), ['id' => 'dialog_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
