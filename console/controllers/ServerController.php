<?php

namespace console\controllers;

use GameQ\GameQ;
use frontend\modules\hosting\models\HostingGames;
use frontend\modules\hosting\models\HostingServers;
use frontend\modules\hosting\models\Ssh;
use yii\console\Controller;

class ServerController extends Controller
{
    public function actionStart($server_id)
    {
        $server = HostingServers::find()
            ->with('location')
            ->where(['id' => $server_id])
            ->one();

        $config = HostingGames::getBaseConfig($server, $server->location);

        $ssh = new Ssh();
        $ssh->connect($server->location);
        $result = $ssh->action('server/start', [
            'id' => 'fun' . $server->id,
            'game_id' => $server->game_id,
            'config' => json_encode($config)
        ]);

        var_dump($result);
    }

    public function actionTest()
    {
        $GameQ = new GameQ();
        $GameQ->setOption('timeout', 2);

        $GameQ->addServer(['type' => 'samp', 'host' => '194.58.118.252:7525']);
        $apiResult = $GameQ->process();
        $GameQ->clearServers();

        var_dump($apiResult);
    }

    public function actionUpdateSystemLoad()
    {
        $servers = HostingServers::find()
            ->with('location')
            ->where(['status' => HostingServers::STATUS_ACTIVE])
            ->all();

        $ssh = new Ssh();
        $lastLocation = '';
        foreach ($servers AS $server) {
            if ($server->location->ip != $lastLocation) {
                $lastLocation = $server->location->ip;
                $ssh->connect($server->location);
            }

            $load = $ssh->action('server/system-load', [
                'id' => 'fun' . $server->id
            ]);

            if (!empty($load)) {
                $array = explode('t', $load);

                if (isset($array[0])) {
                    $server->cpu_load = $array[0];
                }

                if (isset($array[1])) {
                    $server->ram_load = $array[1];
                }

                $server->save();
            }
        }
    }
}