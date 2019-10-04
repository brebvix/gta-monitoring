<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "games".
 *
 * @property int $id
 * @property string $title
 *
 * @property Servers[] $servers
 */
class Games extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'games';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('main', 'Заголовок'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServers()
    {
        return $this->hasMany(Servers::className(), ['game_id' => 'id']);
    }

    public function getColor()
    {
        switch ($this->id) {
            case 1:
                return '#26c6da';
            case 2:
                return '#7460ee';
            case 3:
                return '#f1effd';
            case 4:
                return '#e8fdeb';
            case 7:
                return '#fff8ec';
        }
    }
}
