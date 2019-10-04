<?php

namespace frontend\models\form\advertising;

use common\models\AdvertisingBanners;
use common\models\Links;
use Yii;
use common\models\AdvertisingBannersBuy;
use yii\helpers\HtmlPurifier;
use yii\web\UploadedFile;

class BannerBuyForm extends AdvertisingBannersBuy
{
    public $user_id = 1;
    public $link;
    public $banner_file;

    public function rules()
    {
        $rules = [
            //['banner_file', 'required'],
            ['user_id', 'safe'],
            [['banner_file'], 'file', 'extensions' => 'png', 'skipOnEmpty' => true, 'maxSize' => 1000000],
            ['days', 'integer', 'min' => 1, 'max' => 30],
        ];

        return array_merge($rules, parent::rules());
    }

    public function buy()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->banner_file = UploadedFile::getInstance($this, 'banner_file');

        $user = Yii::$app->user->identity;
        $banner = AdvertisingBanners::findOne(['id' => $this->banner_id]);
        if (empty($banner) || $banner->status == AdvertisingBanners::STATUS_BUSY) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Баннер не найден или уже был куплен.'));

            return false;
        }

        if ($user->balance < ($banner->price * $this->days)) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'У вас недостаточно средств на балансе для аренды баннера.'));

            return false;
        }

        if ($this->banner_file && $this->validate()) {
            $path = 'images/fun/' . rand(991212, 999999999) . '.' . $this->banner_file->extension;
            $saveResult = $this->banner_file->saveAs($path);
        } else {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Ошибка при загрузке баннера, проверьте соответствие условиям.'));

            return false;
        }

        if (!$saveResult) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Ошибка при загрузке баннера, попробуйте еще раз.'));

            return false;
        }


        $user->balance -= ($banner->price * $this->days);
        $user->save();

        $link = new Links();
        $link->identifier = md5(time() + rand(0,100000));
        $link->link = $this->link;
        $link->save();

        $buyBanner = new AdvertisingBannersBuy();
        $buyBanner->user_id = $user->id;
        $buyBanner->days = $this->days;
        $buyBanner->status = AdvertisingBannersBuy::STATUS_ACTIVE;
        $buyBanner->title = HtmlPurifier::process($this->title);
        $buyBanner->link_id = $link->id;
        $buyBanner->image_path = '/' . $path;
        $buyBanner->banner_id = $banner->id;
        $buyBanner->save();

        $banner->status = AdvertisingBanners::STATUS_BUSY;
        $banner->buy_id = $buyBanner->id;
        return $banner->save();
    }


}