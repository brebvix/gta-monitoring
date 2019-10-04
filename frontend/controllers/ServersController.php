<?php
namespace frontend\controllers;

use common\models\UserFavoriteServers;
use frontend\models\search\ServersSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class ServersController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new ServersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'serversSearchModel' => $searchModel,
            'serversProvider' => $dataProvider,
            'game_id' => -1
        ]);
    }

    public function actionSamp()
    {
        $searchModel = new ServersSearch();
        $searchModel->game_id = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'serversSearchModel' => $searchModel,
            'serversProvider' => $dataProvider,
            'game_id' => 1
        ]);
    }

    public function actionCrmp()
    {
        $searchModel = new ServersSearch();
        $searchModel->game_id = 2;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'serversSearchModel' => $searchModel,
            'serversProvider' => $dataProvider,
            'game_id' => 2
        ]);
    }

    public function actionFivem()
    {
        $searchModel = new ServersSearch();
        $searchModel->game_id = 3;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'serversSearchModel' => $searchModel,
            'serversProvider' => $dataProvider,
            'game_id' => 3
        ]);
    }

    public function actionMta()
    {
        $searchModel = new ServersSearch();
        $searchModel->game_id = 4;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'serversSearchModel' => $searchModel,
            'serversProvider' => $dataProvider,
            'game_id' => 4
        ]);
    }

    public function actionRageMultiplayer()
    {
        $searchModel = new ServersSearch();
        $searchModel->game_id = 7;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'serversSearchModel' => $searchModel,
            'serversProvider' => $dataProvider,
            'game_id' => 7
        ]);
    }

    public function actionFavorites()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => UserFavoriteServers::find()
                ->where(['user_id' => Yii::$app->user->id])
                ->with('server'),
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        return $this->render('favorites', [
            'serversProvider' => $dataProvider,
            'game_id' => 1,
        ]);
    }
}