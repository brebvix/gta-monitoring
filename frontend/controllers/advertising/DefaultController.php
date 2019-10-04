<?php
namespace frontend\controllers\advertising;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('/advertising/index');
    }
}