<?php

namespace frontend\controllers\advertising;

use frontend\models\form\advertising\BannerBuyForm;
use yii\web\Controller;
use Yii;
use common\models\AdvertisingBanners;

class BannerController extends Controller
{


    public function actionBuy($position)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->set('lastPage', Yii::$app->request->url);
            Yii::$app->session->setFlash('warning', Yii::t('main', 'Авторизуйтесь для покупки баннера.'));

            return $this->redirect(['/site/login']);
        }

        $banner = AdvertisingBanners::findOne((['id' => (int) $position]));

        if (empty($banner) || $banner->status == AdvertisingBanners::STATUS_BUSY) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'К сожалению это место уже арендовали.'));

            return $this->redirect(['/advertising']);
        }

        $form = new BannerBuyForm();
        $form->banner_id = $banner->id;
        if ($form->load(Yii::$app->request->post()) && $form->buy()) {
            Yii::$app->session->setFlash('success', Yii::t('main', 'Вы успешно арендовали баннер.'));

            return $this->redirect(['/advertising']);
        }

        return $this->render('buy', [
            'banner' => $banner,
            'model' => $form,
        ]);
    }
}