<?php

namespace frontend\controllers;

use yii\web\Controller;
use common\models\Links;
use yii\web\NotFoundHttpException;

class LinksController extends Controller
{
    public function actionGo($identifier)
    {
        $link = Links::findOne(['identifier' => $identifier]);

        if (empty($link)) {
            throw new NotFoundHttpException ();
        }

        $link->clicks++;
        $link->save();

        return $this->redirect($link->link);
    }
}