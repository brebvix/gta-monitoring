<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "advertising_banners_buy".
 *
 * @property int $id
 * @property int $user_id
 * @property string $date
 * @property int $days
 * @property int $status
 * @property string $title
 * @property string $image_path
 * @property int $banner_id
 * @property int $link_id
 *
 * @property User $user
 * @property Links $link
 */
class AdvertisingBannersBuy extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 0;
    const STATUS_NO_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'advertising_banners_buy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'days', 'link'], 'required'],
            [['user_id', 'days', 'status'], 'integer'],
            [['date', 'title', 'image_path'], 'safe'],
            ['title', 'string', 'max' => 16],
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
            'user_id' => Yii::t('main', 'Пользователь'),
            'date' => Yii::t('main', 'Дата'),
            'title' => Yii::t('main', 'Заголовок'),
            'days' => Yii::t('main', 'Дни'),
            'status' => Yii::t('main', 'Статус'),
            'link' => Yii::t('main', 'Ссылка'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getLink()
    {
        return $this->hasOne(Links::className(), ['id' => 'link_id']);
    }

    public function getBanner()
    {
        return $this->hasOne(AdvertisingBanners::className(), ['id' => 'banner_id']);
    }
}
