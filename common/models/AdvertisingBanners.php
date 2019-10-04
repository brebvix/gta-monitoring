<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "advertising_banners".
 *
 * @property int $id
 * @property string $size Размер баннера
 * @property int $title Есть ли заголовок
 * @property int $status
 * @property int $buy_id
 * @property int $price
 */
class AdvertisingBanners extends \yii\db\ActiveRecord
{
    const STATUS_FREE = 0;
    const STATUS_BUSY = 1;
    const TITLE_NO = 0;
    const TITLE_YES = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'advertising_banners';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['size'], 'required'],
            [['title', 'status', 'buy_id', 'price'], 'integer'],
            [['size'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'size' => Yii::t('main', 'Размер баннера'),
            'title' => Yii::t('main', 'Есть ли заголовок'),
            'status' => Yii::t('main', 'Статус'),
            'buy_id' => Yii::t('main', 'Покупатель'),
            'price' => Yii::t('main', 'Цена, руб.'),
        ];
    }

    public function getBuy()
    {
        return $this->hasOne(AdvertisingBannersBuy::className(), ['buy_id' => 'id']);
    }
}
