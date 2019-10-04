<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "players_relations".
 *
 * @property int $id
 * @property int $player_id
 * @property int $server_id
 * @property int $minutes
 * @property string $date
 *
 * @property Players $player
 * @property Servers $server
 */
class PlayersRelations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'players_relations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['player_id', 'server_id'], 'required'],
            [['player_id', 'server_id', 'minutes'], 'integer'],
            [['date'], 'safe'],
            [['player_id'], 'exist', 'skipOnError' => true, 'targetClass' => Players::className(), 'targetAttribute' => ['player_id' => 'id']],
            [['server_id'], 'exist', 'skipOnError' => true, 'targetClass' => Servers::className(), 'targetAttribute' => ['server_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'player_id' => Yii::t('main', 'Игрок'),
            'server_id' => Yii::t('main', 'Сервер'),
            'minutes' => Yii::t('main', 'Время на сервере'),
            'date' => Yii::t('main', 'Последняя активность'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayer()
    {
        return $this->hasOne(Players::className(), ['id' => 'player_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServer()
    {
        return $this->hasOne(Servers::className(), ['id' => 'server_id'])
            ->with('game');
    }
}
