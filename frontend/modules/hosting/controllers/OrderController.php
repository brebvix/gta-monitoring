<?php

namespace frontend\modules\hosting\controllers;

use frontend\modules\hosting\models\form\HostingFinalOrderForm;
use frontend\modules\hosting\models\HostingGamesVersions;
use Yii;
use yii\web\Controller;
use frontend\modules\hosting\models\HostingGames;
use frontend\modules\hosting\models\HostingLocations;

class OrderController extends Controller
{
    public function actionIndex()
    {
        Yii::$app->params['no_layout_card'] = true;

        $gamesModel = HostingGames::find()
            ->with('versions')
            ->all();

        return $this->render('index', [
            'games' => $gamesModel
        ]);
    }

    public function actionStepTwo($game_id)
    {
        $gameModel = HostingGames::find()
            ->with('versions')
            ->where(['id' => (int)$game_id])
            ->one();

        if (empty($gameModel)) {
            return $this->redirect(['index']);
        }

        Yii::$app->params['no_layout_card'] = true;

        return $this->render('step_two', [
            'gameModel' => $gameModel
        ]);
    }

    public function actionStepThree($game_id, $version_id)
    {
        $gameModel = HostingGames::findOne(['id' => (int)$game_id]);

        $versionModel = HostingGamesVersions::findOne(['id' => (int) $version_id, 'game_id' => (int) $game_id]);

        if (empty($gameModel) || empty($versionModel)) {
            return $this->redirect(['index']);
        }

        Yii::$app->params['no_layout_card'] = true;

        $locations = HostingLocations::find()
            ->select(['id', 'ip', 'title'])
            ->all();

        return $this->render('step_three', [
            'gameModel' => $gameModel,
            'versionModel' => $versionModel,
            'locations' => $locations
        ]);
    }

    public function actionStepFour($game_id, $version_id, $location_id)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->set('lastPage', Yii::$app->request->url);
            Yii::$app->session->setFlash('warning', Yii::t('main', 'Авторизуйтесь для аренды сервера.'));

            return $this->redirect(['/site/login']);
        }

        $gameModel = HostingGames::findOne(['id' => (int)$game_id]);

        if (empty($gameModel)) {
            return $this->redirect(['index']);
        }

        $versionModel = HostingGamesVersions::findOne(['id' => (int) $version_id, 'game_id' => (int) $game_id]);

        if (empty($versionModel)) {
            return $this->redirect(['step-two', 'game_id' => $game_id]);
        }

        $locationModel = HostingLocations::find()
            ->select(['id', 'ip', 'title'])
            ->where(['id' => (int)$location_id])
            ->one();

        if (empty($locationModel)) {
            return $this->redirect(['step-three', 'game_id' => $game_id, 'version_id' => $version_id]);
        }

        Yii::$app->params['no_layout_card'] = true;

        $finalFormModel = new HostingFinalOrderForm();

        if ($finalFormModel->load(Yii::$app->request->post()) && $finalFormModel->validateOrder($gameModel, $locationModel, $versionModel)) {
            Yii::$app->session->setFlash('success', Yii::t('main', 'Вы успешно арендовали сервер!'));

            return $this->redirect(['/hosting/panel']);
        }

        return $this->render('step_four', [
            'gameModel' => $gameModel,
            'versionModel' => $versionModel,
            'locationModel' => $locationModel,
            'model' => $finalFormModel,
        ]);
    }
}