<?php

namespace frontend\modules\hosting\models;

use Yii;

/**
 * This is the model class for table "hosting_games_versions".
 *
 * @property int $id
 * @property int $game_id
 * @property string $title
 * @property string $archive
 *
 * @property HostingGames $game
 * @property HostingServers[] $hostingServers
 */
class HostingGamesVersions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hosting_games_versions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['game_id', 'title', 'archive'], 'required'],
            [['game_id'], 'integer'],
            [['title', 'archive'], 'string', 'max' => 32],
            [['game_id'], 'exist', 'skipOnError' => true, 'targetClass' => HostingGames::className(), 'targetAttribute' => ['game_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'game_id' => Yii::t('main', 'Game ID'),
            'title' => Yii::t('main', 'Title'),
            'archive' => Yii::t('main', 'Archive'),
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
    public function getHostingServers()
    {
        return $this->hasMany(HostingServers::className(), ['version_id' => 'id']);
    }
}
