<?php

namespace frontend\modules\hosting\controllers;

use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        Yii::$app->params['no_layout_card'] = true;

        return $this->render('index');
    }
}