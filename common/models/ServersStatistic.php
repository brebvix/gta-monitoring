<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "servers_statistic".
 *
 * @property int $id
 * @property int $server_id
 * @property string $date
 * @property int $players
 *
 * @property Servers $server
 */
class ServersStatistic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servers_statistic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['server_id', 'players'], 'required'],
            [['server_id', 'players'], 'integer'],
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
            'players' => Yii::t('main', 'Игроки'),
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
