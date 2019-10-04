<?php

namespace frontend\controllers\advertising;

use frontend\models\form\advertising\BannerBuyForm;
use frontend\models\form\advertising\LinkBuyForm;
use yii\web\Controller;
use Yii;
use common\models\AdvertisingBanners;

class LinkController extends Controller
{
    public function actionBuy()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->set('lastPage', Yii::$app->request->url);
            Yii::$app->session->setFlash('warning', Yii::t('main', 'Авторизуйтесь для покупки ссылки.'));

            return $this->redirect(['/site/login']);
        }

        $form = new LinkBuyForm();

        if ($form->load(Yii::$app->request->post()) && $form->buyLink()) {
            Yii::$app->session->setFlash('success', Yii::t('main', 'Вы успешно купили ссылку.'));

            return $this->redirect(['/advertising']);
        }

        return $this->render('buy', [
            'model' => $form,
        ]);
    }
}