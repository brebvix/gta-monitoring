<?php

namespace frontend\modules\hosting\controllers;

use frontend\modules\hosting\models\HostingGames;
use frontend\modules\hosting\models\HostingServers;
use frontend\modules\hosting\models\Ssh;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class PanelController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'server_id', 'start', 'restart', 'stop'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        Yii::$app->params['no_layout_card'] = true;

        $servers = HostingServers::find()
            ->with('game')
            ->with('location')
            ->where(['user_id' => Yii::$app->user->id])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'servers' => $servers
        ]);
    }

    public function actionView($server_id)
    {
        Yii::$app->params['no_layout_card'] = true;

        $server = HostingServers::find()
            ->with('game')
            ->with('location')
            ->where(['user_id' => Yii::$app->user->id, 'id' => (int)$server_id])
            ->one();

        if (empty($server)) {
            Yii::$app->session->setFlash('warning', Yii::t('main', 'Сервер не найден.'));

            return $this->redirect(['index']);
        }

        $serverLogFilePath = "ftp://fun{$server->id}:{$server->ftp_password}@{$server->location->ip}/server_log.txt";
        if (is_file($serverLogFilePath)) {
            $conn_id = @ftp_connect($server->location->ip);
            @ftp_login($conn_id, 'fun' . $server->id, $server->ftp_password);
            @ftp_pasv($conn_id, true);
            $h = @fopen('php://temp', 'r+');
            @ftp_fget($conn_id, $h, '/server_log.txt', FTP_BINARY, 0);
            $fstats = @fstat($h);
            @fseek($h, 0);
            $serverLogFile = nl2br(@fread($h, $fstats['size']));
            @fclose($h);
            @ftp_close($conn_id);
        }


        return $this->render('view', [
            'server' => $server,
            'serverLog' => $serverLogFile ?? ''
        ]);
    }

    public function actionStart($server_id)
    {
        $server = HostingServers::find()
            ->with('game')
            ->with('location')
            ->where(['user_id' => Yii::$app->user->id, 'id' => (int)$server_id])
            ->one();

        if (empty($server)) {
            Yii::$app->session->setFlash('warning', Yii::t('main', 'Сервер не найден.'));

            return $this->redirect(['index']);
        }

        $config = HostingGames::getBaseConfig($server, $server->location);

        $ssh = new Ssh();
        $ssh->connect($server->location);
        $result = $ssh->action('server/start', [
            'id' => 'fun' . $server->id,
            'game_id' => $server->game_id,
            'config' => json_encode($config)
        ]);

        if ($result == 'ok') {
            $server->status = HostingServers::STATUS_ACTIVE;
            $server->save();

            Yii::$app->session->setFlash('success', Yii::t('main', 'Сервер успешно запущен.'));
        } else {
            $server->status = HostingServers::STATUS_NO_ACTIVE;
            $server->save();

            Yii::$app->session->setFlash('success', Yii::t('main', 'Ошибка запуска сервера, обратитесь в  поддержку.'));
        }

        return $this->redirect(['view', 'server_id' => $server_id]);
    }

    public function actionStop($server_id) {
        $server = HostingServers::find()
            ->with('game')
            ->with('location')
            ->where(['user_id' => Yii::$app->user->id, 'id' => (int)$server_id])
            ->one();

        if (empty($server)) {
            Yii::$app->session->setFlash('warning', Yii::t('main', 'Сервер не найден.'));

            return $this->redirect(['index']);
        }

        $ssh = new Ssh();
        $ssh->connect($server->location);
        $ssh->action('server/stop', [
            'id' => 'fun' . $server->id
        ]);

        $server->status = HostingServers::STATUS_NO_ACTIVE;
        $server->save();

        Yii::$app->session->setFlash('success', Yii::t('main', 'Сервер успешно остановлен.'));

        return $this->redirect(['view', 'server_id' => $server_id]);
    }


    public function actionRestart($server_id)
    {
        $server = HostingServers::find()
            ->with('game')
            ->with('location')
            ->where(['user_id' => Yii::$app->user->id, 'id' => (int)$server_id])
            ->one();

        if (empty($server)) {
            Yii::$app->session->setFlash('warning', Yii::t('main', 'Сервер не найден.'));

            return $this->redirect(['index']);
        }

        $config = HostingGames::getBaseConfig($server, $server->location);

        $ssh = new Ssh();
        $ssh->connect($server->location);
        $result = $ssh->action('server/restart', [
            'id' => 'fun' . $server->id,
            'game_id' => $server->game_id,
            'config' => json_encode($config)
        ]);

        if ($result == 'ok') {
            $server->status = HostingServers::STATUS_ACTIVE;
            $server->save();

            Yii::$app->session->setFlash('success', Yii::t('main', 'Сервер успешно перезапущен.'));
        } else {
            $server->status = HostingServers::STATUS_NO_ACTIVE;
            $server->save();

            Yii::$app->session->setFlash('success', Yii::t('main', 'Ошибка перезапуска сервера, обратитесь в  поддержку.'));
        }

        return $this->redirect(['view', 'server_id' => $server_id]);
    }
}