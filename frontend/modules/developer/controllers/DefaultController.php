<?php
namespace frontend\modules\developer\controllers;

use frontend\modules\developer\models\search\QuestionsSearch;
use Yii;
use yii\base\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $model = new QuestionsSearch();

        return $this->render('questions', [
            'dataProvider' => $model->search(),
        ]);
    }
}