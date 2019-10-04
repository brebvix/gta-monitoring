<?php

namespace frontend\controllers;

use common\models\PlayersRelations;
use common\models\Servers;
use common\models\ServersStatistic;
use common\models\ServersStatisticMonth;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;

class ApiController extends Controller
{
    public function actionGet($method, $identifier, $forJavaScript = false, $per = 'day', $type = 'online')
    {
        $this->layout = false;

        $server = Servers::getByIdentifier($identifier);

        if (empty($server)) {
            echo '{"found": false}';
            return;
        }

        switch ($method) {
            case 'servers':
                $variable = 'server';
                $result = $this->_apiByServer($server);
                break;
            case 'statistics':
                $variable = 'statistic';

                if (in_array($per, ['day', 'week', 'month'])) {
                    $result = $this->_getStatistic($server, $per);
                } else {
                    $result = [
                        'found' => true,
                        'error' => 'Bad {per} parameter',
                    ];
                }

                break;
            case 'players':
                $variable = 'players';

                if (in_array($type, ['online', 'top'])) {
                    $result = $this->_getPlayers($server, $type);
                } else {
                    $result = [
                        'found' => true,
                        'error' => 'Bad {type} parameter',
                    ];
                }

                break;
            default:
                throw new HttpException(404, 'Method not found');
        }

        if ($forJavaScript) {
            echo 'var ' . $variable . ' = JSON.parse(\'' . json_encode($result, JSON_UNESCAPED_UNICODE) . '\');';
        } else {
            echo json_encode($result);
        }

        exit();
    }

    private function _getPlayers($server, $type)
    {
        $resultArray = [
            'serverId' => $server->id,
            'type' => $type,
            'list' => [],
        ];

        if ($type == 'online') {
            $last30Min = strtotime(date('Y-m-d H:m:s')) - 1800;

            $playersRelations = PlayersRelations::find()
                ->where(['server_id' => $server->id])
                ->andWhere(['>=', 'date', date('Y-m-d H:m:s', $last30Min)])
                ->orderBy(['date' => SORT_DESC])
                ->with('player')
                ->all();
        } else {
            $playersRelations = PlayersRelations::find()
                ->where(['server_id' => $server->id])
                ->orderBy(['minutes' => SORT_DESC])
                ->with('player')
                ->limit(100)
                ->all();
        }

        foreach ($playersRelations AS $relation) {
            $resultArray['list'][] = ['id' => $relation->player->id, 'nickname' => $relation->player->nickname, 'playedMinutes' => $relation->minutes, 'lastActivity' => $relation->date];
        }

        return $resultArray;
    }

    private function _getStatistic($server, $per)
    {
        $resultArray = [
            'serverId' => $server->id,
            'per' => $per,
            'averageOnline' => 0,
            'maximumOnline' => 0,
            'list' => [],
        ];

        $averageAmount = 0;
        $averageCount = 0;

        switch ($per) {
            case 'day':
                $statistics = ServersStatistic::find()
                    ->where(['server_id' => $server->id])
                    ->orderBy(['id' => SORT_DESC])
                    ->all();

                foreach ($statistics AS $statistic) {
                    $averageAmount += $statistic->players;
                    $averageCount++;

                    if ($statistic->players > $resultArray['maximumOnline']) {
                        $resultArray['maximumOnline'] = $statistic->players;
                    }

                    $resultArray['list'][] = ['id' => $statistic->id, 'players' => $statistic->players, 'createdAt' => $statistic->date];
                }
                break;
            case 'week':
                $statistics = ServersStatisticMonth::find()
                    ->where(['server_id' => $server->id])
                    ->orderBy(['id' => SORT_DESC])
                    ->limit(7)
                    ->all();

                foreach ($statistics AS $statistic) {
                    $averageAmount += $statistic->average_online;
                    $averageCount++;

                    if ($statistic->maximum_online > $resultArray['maximumOnline']) {
                        $resultArray['maximumOnline'] = $statistic->maximum_online;
                    }

                    $resultArray['list'][] = ['id' => $statistic->id, 'averageOnline' => $statistic->average_online, 'maximumOnline' => $statistic->maximum_online, 'createdAt' => $statistic->date];
                }
                break;
            case 'month':
                $statistics = ServersStatisticMonth::find()
                    ->where(['server_id' => $server->id])
                    ->orderBy(['id' => SORT_DESC])
                    ->limit(30)
                    ->all();

                foreach ($statistics AS $statistic) {
                    $averageAmount += $statistic->average_online;
                    $averageCount++;

                    if ($statistic->maximum_online > $resultArray['maximumOnline']) {
                        $resultArray['maximumOnline'] = $statistic->maximum_online;
                    }

                    $resultArray['list'][] = ['id' => $statistic->id, 'averageOnline' => $statistic->average_online, 'maximumOnline' => $statistic->maximum_online, 'createdAt' => $statistic->date];
                }
                break;
        }

        if ($averageAmount > 0 && $averageCount > 0) {
            $resultArray['averageOnline'] = round($averageAmount / $averageCount);
        }

        return $resultArray;
    }

    public function actionAsJsonByAddress($address, $jsVariable = false)
    {
        $this->layout = false;

        if (empty($address)) {
            echo '{"found": false}';
            return;
        }

        $address = explode(':', $address);

        if (count($address) != 2) {
            echo '{"found": false}';
            return;
        }

        $server = Servers::findOne(['ip' => $address[0], 'port' => (int)$address[1]]);

        if (empty($server)) {
            echo '{"found": false}';
            return;
        }

        $resultArray = $this->_apiByServer($server);

        if ($jsVariable) {
            echo 'var server = JSON.parse(\'' . json_encode($resultArray) . '\');';
        } else {
            echo json_encode($resultArray);
        }
    }

    public function actionAsJson($server_id, $jsVariable = false)
    {
        $this->layout = false;

        $server = Servers::findOne(['id' => $server_id]);

        if (empty($server)) {
            echo '{"found": false}';
            return;
        }

        $resultArray = $this->_apiByServer($server);

        if ($jsVariable) {
            echo 'var server = JSON.parse(\'' . json_encode($resultArray, JSON_UNESCAPED_UNICODE) . '\');';
        } else {
            echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
        }
    }

    private function _apiByServer($server)
    {
        return [
            'id' => $server->id,
            'ip' => $server->ip,
            'port' => (int) $server->port,
            'title' => $server->title,
            'gamemode' => $server->mode,
            'language' => $server->language,
            'version' => $server->version,
            'site' => $server->site,
            'players' => [
                'number' => (int) $server->players,
                'maximum' => (int) $server->maxplayers,
                'averageNumber' => (int) $server->average_online,
                'maximumNumber' => (int) $server->maximum_online,
            ],
            'game' => [
                'id' => $server->game_id,
                'title' => $server->game->title,
            ],
            'rating' => (float) $server->rating,
            'found' => true,
            'onlineStatus' => (bool) $server->status,
            'createdAt' => $server->created_at,
        ];
    }

    public function actionWebOne($server_id)
    {
        $this->layout = false;

        $this->layout = false;

        $server = Servers::findOne(['id' => $server_id]);

        if (empty($server)) {
            echo '{"found": false}';
            return;
        }

        return $this->render('web-one', [
            'server' => $server,
        ]);
    }

    public function actionWebOneDark($server_id)
    {
        $this->layout = false;

        $this->layout = false;

        $server = Servers::findOne(['id' => $server_id]);

        if (empty($server)) {
            echo '{"found": false}';
            return;
        }

        return $this->render('web-one-dark', [
            'server' => $server,
        ]);
    }

    public function actionWebTwo($server_id)
    {
        $this->layout = false;

        $this->layout = false;

        $server = Servers::findOne(['id' => $server_id]);

        if (empty($server)) {
            echo '{"found": false}';
            return;
        }

        return $this->render('web-two', [
            'server' => $server,
        ]);
    }
}