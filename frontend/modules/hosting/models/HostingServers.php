<?php

namespace frontend\modules\hosting\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "hosting_servers".
 *
 * @property int $id
 * @property int $user_id
 * @property int $game_id
 * @property int $location_id
 * @property int $version_id
 * @property int $port
 * @property int $slots
 * @property string $ftp_password
 * @property string $database_password
 * @property double $cpu_load
 * @property double $ram_load
 * @property string $start_date
 * @property string $end_date
 * @property int $status
 *
 * @property HostingGames $game
 * @property HostingLocations $location
 * @property User $user
 */
class HostingServers extends \yii\db\ActiveRecord
{
    const STATUS_NO_ACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hosting_servers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'game_id', 'location_id', 'port', 'slots', 'ftp_password', 'database_password', 'version_id'], 'required'],
            [['user_id', 'game_id', 'location_id', 'version_id', 'port', 'slots', 'status'], 'integer'],
            [['cpu_load', 'ram_load'], 'number'],
            [['start_date', 'end_date'], 'safe'],
            [['ftp_password', 'database_password'], 'string', 'max' => 32],
            [['game_id'], 'exist', 'skipOnError' => true, 'targetClass' => HostingGames::className(), 'targetAttribute' => ['game_id' => 'id']],
            [['version_id'], 'exist', 'skipOnError' => true, 'targetClass' => HostingGamesVersions::className(), 'targetAttribute' => ['version_id' => 'id']],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => HostingLocations::className(), 'targetAttribute' => ['location_id' => 'id']],
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
            'user_id' => Yii::t('main', 'User ID'),
            'game_id' => Yii::t('main', 'Game ID'),
            'version_id' => Yii::t('main', 'Version ID'),
            'location_id' => Yii::t('main', 'Location ID'),
            'port' => Yii::t('main', 'Port'),
            'slots' => Yii::t('main', 'Slots'),
            'ftp_password' => Yii::t('main', 'Ftp Password'),
            'database_password' => Yii::t('main', 'Database Password'),
            'cpu_load' => Yii::t('main', 'Cpu Load'),
            'ram_load' => Yii::t('main', 'Ram Load'),
            'start_date' => Yii::t('main', 'Start Date'),
            'end_date' => Yii::t('main', 'End Date'),
            'status' => Yii::t('main', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(HostingGames::className(), ['id' => 'game_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(HostingLocations::className(), ['id' => 'location_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVersion()
    {
        return $this->hasOne(HostingGamesVersions::className(), ['id' => 'version_id']);
    }

    public static function getAvailablePort(HostingGames $gameModel)
    {
        $tempArray = [];

        for ($i = $gameModel->start_port; $i < $gameModel->end_port; $i++) {
            $tempArray[$i] = $i;
        }

        $reservedPortsModel = HostingServers::find()
            ->select(['port'])
            ->where(['game_id' => $gameModel->id])
            ->all();

        foreach ($reservedPortsModel AS $value) {
            unset($tempArray[$value->port]);
        }

        return array_rand($tempArray);
    }
}
