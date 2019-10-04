<?php

namespace frontend\modules\hosting\models;

use Yii;

/**
 * This is the model class for table "hosting_games".
 *
 * @property int $id
 * @property string $title
 * @property string $short
 * @property int $min_slots
 * @property int $max_slots
 * @property int $start_port
 * @property int $end_port
 * @property double $price
 * @property int $price_type
 *
 * @property HostingServers[] $hostingServers
 */
class HostingGames extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hosting_games';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'short', 'min_slots', 'max_slots', 'start_port', 'end_port', 'price'], 'required'],
            [['min_slots', 'max_slots', 'start_port', 'end_port', 'price_type'], 'integer'],
            [['price'], 'number'],
            [['title', 'short'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'title' => Yii::t('main', 'Title'),
            'short' => Yii::t('main', 'Short'),
            'min_slots' => Yii::t('main', 'Min Slots'),
            'max_slots' => Yii::t('main', 'Max Slots'),
            'start_port' => Yii::t('main', 'Start Port'),
            'end_port' => Yii::t('main', 'End Port'),
            'price' => Yii::t('main', 'Price'),
            'price_type' => Yii::t('main', 'Price Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHostingServers()
    {
        return $this->hasMany(HostingServers::className(), ['game_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVersions()
    {
        return $this->hasMany(HostingGamesVersions::className(), ['game_id' => 'id']);
    }

    public static function getBaseConfig($server, $location)
    {
        switch ($server->game_id) {
            case 1:
                return [
                    'ip' => $location->ip,
                    'port' => $server->port,
                    'maxplayers' => $server->slots
                ];
                break;
            case 2:
                return [
                    'ip' => $location->ip,
                    'port' => $server->port,
                    'maxplayers' => $server->slots
                ];
                break;
        }

        return false;
    }
}
