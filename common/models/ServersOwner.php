<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "servers_owner".
 *
 * @property int $id
 * @property int $user_id
 * @property int $server_id
 *
 * @property Servers $server
 * @property User $user
 */
class ServersOwner extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servers_owner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'server_id'], 'required'],
            [['user_id', 'server_id'], 'integer'],
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
            'id' => Yii::t('main', 'ID'),
            'user_id' => Yii::t('main', 'Пользователь'),
            'server_id' => Yii::t('main', 'Сервер'),
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
