<?php

namespace frontend\controllers;

use common\models\Players;
use frontend\models\form\SearchPlayerForm;
use Yii;
use yii\db\Query;
use yii\helpers\HtmlPurifier;
use yii\web\Controller;
use frontend\models\search\PlayersSearch;

class PlayersController extends Controller
{
    public function actionIndex()
    {
        $searchPlayerForm = new SearchPlayerForm();

        $searchModel = new PlayersSearch();
        $dataProvider = $searchModel->search();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'formModel' => $searchPlayerForm
        ]);
    }

    public function actionView($id, $nickname_eng)
    {
        $searchPlayerForm = new SearchPlayerForm();
        $player = Players::find()
            ->where(['id' => (int)$id])
            ->with('relations')
            ->one();

        if (empty($player)) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Игрок с таким никнеймом не найден.'));

            return $this->redirect(['/players/index']);
        }

        return $this->render('view', [
            'player' => $player,
            'formModel' => $searchPlayerForm
        ]);
    }

    public function actionPlayersList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, nickname AS text')
                ->from('players')
                ->where(['like', 'nickname', HtmlPurifier::process($q) . '%', false])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Players::find((int) $id)->nickname];
        }
        return $out;
    }
}