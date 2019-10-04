<?php
namespace frontend\widgets;

use common\models\AdvertisingBanners;
use common\models\AdvertisingBannersBuy;
use Yii;
use yii\helpers\Url;

class Banner extends \yii\bootstrap\Widget
{
    public $id;

    public function run()
    {
        $banner = AdvertisingBanners::findOne(['id' => $this->id]);

        if ($banner->status == AdvertisingBanners::STATUS_FREE) {
            return $this->render('banners/free', [
                'title' => $banner->title == AdvertisingBanners::TITLE_YES ? $banner->size : '',
                'size' => $banner->size,
                'id' => $banner->id,
            ]);
        }

        $banner_buy = AdvertisingBannersBuy::findOne(['id' => $banner->buy_id]);

        return $this->render('banners/main', [
            'link' => Url::to(['/links/go', 'identifier' => $banner_buy->link->identifier]),
            'image_path' => $banner_buy->image_path,
            'title' => $banner_buy->title,
            'hasTitle' => $banner->title == AdvertisingBanners::TITLE_YES ? true : false
        ]);
    }
}