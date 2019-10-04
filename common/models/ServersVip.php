<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "servers_vip".
 *
 * @property int $id
 * @property int $user_id
 * @property int $server_id
 * @property int $days
 * @property string $date
 * @property int $status
 * @property int $type
 *
 * @property Servers $server
 * @property User $user
 */
class ServersVip extends \yii\db\ActiveRecord
{
    const STATUS_NO_ACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const TYPE_BACKGROUND = 0;
    const TYPE_TOP = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servers_vip';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'server_id', 'days', 'status', 'type'], 'required'],
            [['user_id', 'server_id', 'days', 'status', 'type'], 'integer'],
            [['date'], 'safe'],
            [['server_id'], 'exist', 'skipOnError' => true, 'targetClass' => Servers::className(), 'targetAttribute' => ['server_id' => 'id']],
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
            'server_id' => Yii::t('main', 'Сервер'),
            'days' => Yii::t('main', 'Дни'),
            'date' => Yii::t('main', 'Дата'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServer()
    {
        return $this->hasOne(Servers::className(), ['id' => 'server_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
