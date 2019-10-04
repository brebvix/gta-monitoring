<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "links".
 *
 * @property int $id
 * @property string $identifier
 * @property string $link
 * @property int $clicks
 * @property string $date
 *
 * @property AdvertisingBannersBuy[] $advertisingBannersBuys
 * @property AdvertisingLinks[] $advertisingLinks
 */
class Links extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'links';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['identifier', 'link'], 'required'],
            [['clicks'], 'integer'],
            [['date'], 'safe'],
            [['identifier'], 'string', 'max' => 64],
            [['link'], 'string', 'max' => 128],
            [['identifier'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'identifier' => Yii::t('app', 'Identifier'),
            'link' => Yii::t('app', 'Link'),
            'clicks' => Yii::t('app', 'Clicks'),
            'date' => Yii::t('app', 'Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisingBannersBuys()
    {
        return $this->hasMany(AdvertisingBannersBuy::className(), ['link_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisingLinks()
    {
        return $this->hasMany(AdvertisingLinks::className(), ['link_id' => 'id']);
    }
}
