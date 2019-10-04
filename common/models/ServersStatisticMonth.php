<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "servers_statistic_month".
 *
 * @property int $id
 * @property int $server_id
 * @property string $date
 * @property int $average_online
 * @property int $maximum_online
 *
 * @property Servers $server
 */
class ServersStatisticMonth extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servers_statistic_month';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['server_id'], 'required'],
            [['server_id', 'average_online', 'maximum_online'], 'integer'],
            [['date'], 'safe'],
            [['server_id'], 'exist', 'skipOnError' => true, 'targetClass' => Servers::className(), 'targetAttribute' => ['server_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'server_id' => Yii::t('main', 'Сервер'),
            'date' => Yii::t('main', 'Дата'),
            'average_online' => Yii::t('main', 'Средний онлайн'),
            'maximum_online' => Yii::t('main', 'Максимальный онлайн'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServer()
    {
        return $this->hasOne(Servers::className(), ['id' => 'server_id']);
    }
}
