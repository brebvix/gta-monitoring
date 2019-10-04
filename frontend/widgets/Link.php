<?php
namespace frontend\widgets;

use common\models\AdvertisingLinks;

use Yii;

class Link extends \yii\bootstrap\Widget
{
    public function run()
    {
        $links = AdvertisingLinks::find()
            ->where(['status' => AdvertisingLinks::STATUS_ACTIVE])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('links', ['links' => $links]);
    }
}