<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "players".
 *
 * @property int $id
 * @property string $nickname
 * @property string $nickname_eng
 * @property int $minutes
 * @property string $date
 *
 * @property PlayersRelations[] $playersRelations
 */
class Players extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'players';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nickname', 'nickname_eng'], 'required'],
            [['minutes'], 'integer'],
            [['date'], 'safe'],
            [['nickname'], 'string', 'max' => 32],
            [['nickname_eng'], 'string', 'max' => 48],
            [['nickname'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'nickname' => Yii::t('main', 'Никнейм'),
            'nickname_eng' => Yii::t('main', 'Nickname Eng'),
            'minutes' => Yii::t('main', 'Время в игре'),
            'date' => Yii::t('main', 'Последняя активность'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelations()
    {
        return $this->hasMany(PlayersRelations::className(), ['player_id' => 'id'])
            ->orderBy(['minutes' => SORT_DESC])
            ->with('server');
    }
}
