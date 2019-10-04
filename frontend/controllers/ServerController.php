<?php

namespace frontend\controllers;

use backend\models\search\UserSearch;
use common\models\Games;
use common\models\Servers;
use common\models\ServersDescription;
use common\models\ServersRatingStatistic;
use common\models\ServersStatistic;
use common\models\ServersStatisticMonth;
use common\models\UserFavoriteServers;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use frontend\models\form\AddServerForm;
use frontend\models\form\ServerBuyBackgroundForm;
use frontend\models\form\ServerBuyTopForm;
use yii\web\Cookie;

/**
 * Site controller
 */
class ServerController extends Controller
{

    public function actionIndex()
    {
        return $this->goBack();
    }

    public function actionView($id, $title_eng = null, $game = null)
    {
        Yii::$app->params['no_layout_card'] = true;

        $server = Servers::findOne(['id' => $id]);

        if (empty($server)) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Сервер не найден.'));
            return $this->redirect(['/site/index']);
        }

        $this->_serverView($server);

        $buyBackgroundForm = new ServerBuyBackgroundForm();
        $buyBackgroundForm->server_id = $server->id;

        if (!Yii::$app->user->isGuest && $buyBackgroundForm->load(Yii::$app->request->post()) && $buyBackgroundForm->buyBackground()) {
            Yii::$app->session->setFlash('success', Yii::t('main', 'Вы успешно купили услугу "Выделение сервера".'));
        }

        $buyTopForm = new ServerBuyTopForm();
        $buyTopForm->server_id = $server->id;

        if (!Yii::$app->user->isGuest && $buyTopForm->load(Yii::$app->request->post()) && $buyTopForm->buyLink()) {
            Yii::$app->session->setFlash('success', Yii::t('main', 'Вы успешно купили услугу "Поднятие в ТОП".'));
        }

        return $this->render('main', [
            'server' => $server,
            'lastStatistic' => ServersStatisticMonth::find()
                ->where(['server_id' => $id])
                ->orderBy(['id' => SORT_DESC])
                ->limit(1)
                ->one(),
            'statistics' => ServersStatisticMonth::find()
                ->where(['server_id' => $id])
                ->orderBy(['id' => SORT_ASC])
                ->limit(30)
                ->all(),
            'dayliStatistic' => ServersStatistic::find()
                ->where(['server_id' => $id])
                ->orderBy(['id' => SORT_ASC])
                ->limit(100)
                ->all(),
            'ratingStatistic' => array_reverse(ServersRatingStatistic::find()
                ->where(['server_id' => $id])
                ->orderBy(['id' => SORT_DESC])
                ->limit(30)
                ->all()),
            'buyBackgroundModel' => $buyBackgroundForm,
            'buyTopModel' => $buyTopForm,
        ]);
    }

    public function actionAdd()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->set('lastPage', Yii::$app->request->url);
            Yii::$app->session->setFlash('warning', Yii::t('main', 'Авторизуйтесь для добавления сервера.'));

            return $this->redirect(['/site/login']);
        }

        $form = new AddServerForm();

        if ($form->load(Yii::$app->request->post())) {
            $saveResult = $form->saveServer();

            if (is_object($saveResult)) {
                return $this->redirect(Url::to(['/server/view', 'id' => $saveResult->id, 'title_eng' => $saveResult->title_eng, 'game' => $saveResult->game()]));
            }
            Yii::$app->session->setFlash('success', Yii::t('main', 'Сервер успешно добавлен в мониторинг.'));

            $server = Servers::findOne(['ip' => $form->ip, 'port' => $form->port]);

            if (!empty($server)) {
                return $this->redirect(['view', 'id' => $server->id]);
            }

            return $this->redirect(['/']);
        }

        return $this->render('add', [
            'addModel' => $form,
            'game_list' => Games::find()->all(),
        ]);
    }

    public function actionAddDescription($id)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->set('lastPage', Yii::$app->request->url);
            Yii::$app->session->setFlash('warning', Yii::t('main', 'Авторизуйтесь для добавления описания.'));

            return $this->redirect(['/site/login']);
        }

        $description = new ServersDescription();
        $description->server_id = (int)$id;
        $description->user_id = Yii::$app->user->id;

        if ($description->load(Yii::$app->request->post()) && $description->save()) {
            Yii::$app->session->setFlash('success', Yii::t('main', 'Описание сервера успешно отправлено на модерацию. Спасибо.'));

            return $this->redirect(['/server/view', 'id' => (int)$id]);
        }

        return $this->render('add-description', [
            'model' => $description,
        ]);
    }

    public function actionFavorite($id)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->set('lastPage', Yii::$app->request->url);
            Yii::$app->session->setFlash('warning', Yii::t('main', 'Авторизуйтесь для добавления сервера в избранное.'));

            return $this->redirect(['/site/login']);
        }

        $server = Servers::findOne(['id' => (int)$id]);

        if (empty($server)) {
            Yii::$app->session->setFlash('error', Yii::t('main', 'Сервер не найден.'));
            return $this->redirect(['/']);
        }

        $favoriteCheck = UserFavoriteServers::findOne(['user_id' => Yii::$app->user->id, 'server_id' => $server->id]);

        if (empty($favoriteCheck)) {
            $favoriteModel = new UserFavoriteServers();
            $favoriteModel->user_id = Yii::$app->user->id;
            $favoriteModel->server_id = $server->id;
            $favoriteModel->save();

            Yii::$app->session->setFlash('success', Yii::t('main', 'Сервер успешно добавлен в избранное.'));

            return $this->redirect(['/servers/favorites']);
        } else {
            UserFavoriteServers::deleteAll(['id' => $favoriteCheck->id]);

            Yii::$app->session->setFlash('success', Yii::t('main', 'Сервер успешно убран из избранного.'));

            return $this->redirect(['view', 'id' => $server->id]);
        }
    }

    private function _serverView(&$server)
    {
        $checkView = Yii::$app->session->get('serversViewed', []);
        $checkViewCookie = Yii::$app->response->cookies->get('q2');
        if (!empty($checkViewCookie)) {
            $cookieViewData = json_decode($checkViewCookie, true);

            if (!isset($cookieViewData['srv'])) {
                $cookieViewData['srv'] = [];
            }
        } else {
            $cookieViewData = ['srv' => []];
        }

        if (!isset($checkView[$server->id]) && !isset($cookieViewData['srv'][$server->id])) {
            $checkView[$server->id] = true;
            Yii::$app->session->set('serversViewed', $checkView);
            Yii::$app->response->cookies->add(new Cookie([
                'name' => 'q2',
                'value' => json_encode(['srv' => $checkView]),
                'expire' => time() + 1440,
            ]));

            $server->views++;
            $server->save();
        } else {
            $checkView[$server->id] = true;
            Yii::$app->response->cookies->add(new Cookie([
                'name' => 'q2',
                'value' => json_encode(['srv' => $checkView]),
                'expire' => time() + 1440,
            ]));
        }
    }
}