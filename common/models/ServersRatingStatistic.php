<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "servers_rating_statistic".
 *
 * @property int $id
 * @property int $server_id
 * @property double $rating
 * @property string $date
 * @property int $views
 *
 * @property Servers $server
 */
class ServersRatingStatistic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servers_rating_statistic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['server_id', 'rating'], 'required'],
            [['server_id', 'views'], 'integer'],
            [['rating'], 'number'],
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
            'server_id' => Yii::t('app', 'Server ID'),
            'rating' => Yii::t('app', 'Rating'),
            'date' => Yii::t('app', 'Date'),
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
