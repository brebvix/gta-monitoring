<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "user_login_history".
 *
 * @property int $id
 * @property int $user_id
 * @property string $ip
 * @property string $date
 *
 * @property User $user
 */
class UserLoginHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_login_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'ip'], 'required'],
            [['user_id'], 'integer'],
            [['date'], 'safe'],
            [['ip'], 'string', 'max' => 15],
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
            'user_id' => Yii::t('app', 'User ID'),
            'ip' => Yii::t('app', 'Ip'),
            'date' => Yii::t('app', 'Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $notification = new UserNotifications();
        $notification->user_id = $this->user_id;
        $notification->type = UserNotifications::TYPE_NEW_AUTHORIZE;
        $notification->data = json_encode(['ip' => $this->ip]);
        $notification->save();
    }
}
