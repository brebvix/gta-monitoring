<?php

namespace frontend\controllers;

set_time_limit(0);
ignore_user_abort(1);

use common\models\Achievements;
use common\models\FreelanceServices;
use common\models\FreelanceVacancies;
use common\models\News;
use common\models\Players;
use common\models\PlayersRelations;
use common\models\Servers;
use common\models\ServersStatistic;
use common\models\ServersStatisticMonth;
use common\models\System;
use common\models\User;
use frontend\modules\developer\models\Questions;
use frontend\modules\developer\models\QuestionsCategories;
use GameQ\GameQ;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Json;
use yii\web\Controller;

/**
 * Site controller
 */
class FrontCronController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionUpdateServers($start, $offline = false)
    {
        if ($offline) {
            $serversList = Servers::find()
                ->select(['ip', 'port', 'offline_count', 'status', 'id', 'players', 'game_id'])
                ->where(['status' => Servers::STATUS_OFFLINE])
                ->andWhere(['in', 'game_id', [1, 2]])
                ->offset($start)
                ->limit(50)
                ->all();
        } else {
            $serversList = Servers::find()
                ->select(['ip', 'port', 'offline_count', 'status', 'id', 'players', 'game_id'])
                ->where(['status' => Servers::STATUS_ACTIVE])
                ->andWhere(['in', 'game_id', [1, 2]])
                //->offset($start)
                //->limit(50)
                ->all();
        }

        $playersOnline = 0;
        $serversOnline = 0;

        $GameQ = new GameQ();
        $GameQ->setOption('timeout', 2);

        foreach ($serversList AS $key => $server) {
            $GameQ->addServer(['type' => 'samp', 'host' => $server->ip . ':' . $server->port]);
            $apiResult = $GameQ->process();
            $GameQ->clearServers();
            $apiResult = $apiResult[$server->ip . ':' . $server->port];

            if (!$apiResult['gq_online']) {
                $server->offline_count++;

                if ($server->offline_count > 11) {
                    $server->status = Servers::STATUS_OFFLINE;
                }
            } else {
                $server->offline_count = 0;
                $server->status = Servers::STATUS_ACTIVE;


                if (isset($apiResult['gq_numplayers'])) {
                    $server->players = (int)$apiResult['gq_numplayers'];

                    $playersOnline += $server->players;
                }

                if (isset($apiResult['gq_maxplayers'])) {
                    $server->maxplayers = (int)$apiResult['gq_maxplayers'];
                }

                if (!empty($apiResult['servername'])) {
                    $server->title = HtmlPurifier::process(trim(mb_convert_encoding($apiResult['servername'], 'UTF-8', 'Windows-1251')));
                    $server->title_eng = Questions::translit($server->title);
                }

                if (isset($apiResult['language']) && !empty($apiResult['language'])) {
                    $server->language = HtmlPurifier::process(mb_convert_encoding($apiResult['language'], 'UTF-8', 'Windows-1251'));
                }
                if (isset($apiResult['gametype'])) {
                    $server->mode = HtmlPurifier::process($apiResult['gametype']);
                }
                if (isset($apiResult['version'])) {
                    if ($apiResult['version'] == 'crce' || $apiResult['version'] == 'cr037') {
                        $server->game_id = 2;
                    } else {
                        $server->game_id = 1;
                    }

                    $server->version = HtmlPurifier::process($apiResult['version']);
                }
                if (isset($apiResult['weburl'])) {
                    $server->site = HtmlPurifier::process($apiResult['weburl']);
                }

            }

            if ($server->save() && !empty($server->title)) {
                $serversOnline++;

                $this->_updatePlayers($apiResult['players'], $server->id);
                $this->_updateStatistic($server);
                $this->_checkAchievements($server);

                unset($serversList[$key]);
                usleep(25000);
            }
        }

        System::updateGlobalStatistic('players_online', $playersOnline);
        System::updateGlobalStatistic('servers_online', $serversOnline);
    }

    public function actionUpdateMtaServers()
    {
        $servers = Servers::find()
            ->select(['id', 'ip', 'port', 'players', 'game_id'])
            ->where(['game_id' => 4])
            //->where(['status' => 1])
            ->all();

        $playersOnline = 0;
        $serversOnline = 0;

        $GameQ = new GameQ();
        $GameQ->setOption('timeout', 2);
        //echo '<pre>';
        foreach ($servers AS $server) {
            $GameQ->addServer(['type' => 'mta', 'host' => $server->ip . ':' . $server->port]);
            $serverInfo = $GameQ->process();
            $GameQ->clearServers();

            if (!empty($serverInfo)) {
                $serverInfo = $serverInfo[$server->ip . ':' . $server->port];
                if ($serverInfo['gq_online']) {
                    $server->title = HtmlPurifier::process($serverInfo['gq_hostname']);
                    $server->title_eng = Questions::translit($server->title);
                    if (isset($serverInfo['version'])) {
                        $server->version = $serverInfo['version'];
                    }
                    $server->players = (int)$serverInfo['gq_numplayers'];
                    $server->maxplayers = (int)$serverInfo['gq_maxplayers'];
                    $server->mode = HtmlPurifier::process($serverInfo['gq_gametype']);
                    $server->status = 1;
                    $server->save();

                    $serversOnline++;
                    $playersOnline += $server->players;

                    $this->_updatePlayers($serverInfo['players'], $server->id);
                    $this->_updateStatistic($server);
                    $this->_checkAchievements($server);
                } else {
                    $server->status = 0;
                    $server->save();
                }
            } else {
                $server->status = 0;
                $server->save();
            }
        }

        System::updateGlobalStatistic('players_online', $playersOnline);
        System::updateGlobalStatistic('servers_online', $serversOnline);
    }

    public function actionUpdateRageServers()
    {
        $serverList = file_get_contents('https://cdn.rage.mp/master/');

        if (!$serverList) {
            return false;
        }
        try {
            $serverList = Json::decode($this->convert_from_latin1_to_utf8_recursively($serverList), true);
        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
            return false;
        }

        if (!is_array($serverList)) {
            var_dump($serverList);
            return false;
        }

        $serversOnline = 0;
        $playersOnline = 0;

        foreach ($serverList AS $address => $value) {
            $address = explode(':', $address);
            $server = Servers::find()
                ->select(['ip', 'port', 'id', 'players', 'game_id'])
                ->where(['ip' => $address[0], 'port' => $address[1], 'game_id' => 7])
                ->one();

            if (empty($server)) {
                $server = new Servers();
                $server->game_id = 7;
                $server->ip = $address[0];
                $server->port = $address[1];

                $server->rating = '2.54';
                $server->rating_up = 1;
                $server->rating_down = 0;
            }

            $server->title = HtmlPurifier::process($value['name']);
            $server->title_eng = Questions::translit($server->title);
            $server->mode = HtmlPurifier::process($value['gamemode']);
            $server->site = $value['url'];
            $server->language = $value['lang'];
            $server->players = (int)$value['players'];
            $server->maxplayers = (int)$value['maxplayers'];
            $server->status = 1;

            if ($server->save()) {
                $serversOnline++;
                $playersOnline += $server->players;

                $this->_updateStatistic($server);
                $this->_checkAchievements($server);
            }
        }

        System::updateGlobalStatistic('players_online', $playersOnline);
        System::updateGlobalStatistic('servers_online', $serversOnline);
    }

    public function convert_from_latin1_to_utf8_recursively($dat)
    {
        if (is_string($dat)) {
            return utf8_encode($dat);
        } elseif (is_array($dat)) {
            $ret = [];
            foreach ($dat as $i => $d) $ret[$i] = self::convert_from_latin1_to_utf8_recursively($d);

            return $ret;
        } elseif (is_object($dat)) {
            foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);

            return $dat;
        } else {
            return $dat;
        }
    }

    public function _updatePlayers($playerList, $server_id)
    {
        if (empty($playerList)) {
            return true;
        }

        foreach ($playerList AS $player) {
            $player['gq_name'] = trim(HtmlPurifier::process($player['gq_name']));
            $playerModel = Players::findOne(['nickname' => $player['gq_name']]);

            if (empty($playerModel)) {
                $playerModel = new Players();
                $playerModel->nickname = $player['gq_name'];
                $playerModel->nickname_eng = Questions::translit($playerModel->nickname);
            }

            $playerModel->minutes += 15;
            if (!empty($playerModel->nickname) && !empty($playerModel->nickname_eng)) {
                $playerModel->save();

                $playerRelationModel = PlayersRelations::findOne(['player_id' => $playerModel->id, 'server_id' => $server_id]);

                if (empty($playerRelationModel)) {
                    $playerRelationModel = new PlayersRelations();
                    $playerRelationModel->player_id = $playerModel->id;
                    $playerRelationModel->server_id = $server_id;
                }

                $playerRelationModel->minutes += 15;
                $playerRelationModel->save();

                usleep(25000);
            }
        }
    }

    private function _checkAchievements($server)
    {
        if ($server->players >= 100 && !$server->hasAchievement(4)) {
            $achievement_4 = Achievements::findOne([
                'main_id' => $server->id,
                'main_type' => Achievements::MAIN_TYPE_SERVER,
                'achievement_id' => 4
            ]);

            if (empty($achievement_4)) {
                $achievement_4 = new Achievements();
                $achievement_4->main_id = $server->id;
                $achievement_4->main_type = Achievements::MAIN_TYPE_SERVER;
                $achievement_4->achievement_id = 4;
                return $achievement_4->save();
            }
        }

        if ($server->players >= 200 && !$server->hasAchievement(5)) {
            $achievement_5 = Achievements::findOne([
                'main_id' => $server->id,
                'main_type' => Achievements::MAIN_TYPE_SERVER,
                'achievement_id' => 5
            ]);

            if (empty($achievement_5)) {
                $achievement_5 = new Achievements();
                $achievement_5->main_id = $server->id;
                $achievement_5->main_type = Achievements::MAIN_TYPE_SERVER;
                $achievement_5->achievement_id = 5;
                return $achievement_5->save();
            }
        }

        if ($server->players >= 500 && !$server->hasAchievement(6)) {
            $achievement_6 = Achievements::findOne([
                'main_id' => $server->id,
                'main_type' => Achievements::MAIN_TYPE_SERVER,
                'achievement_id' => 6
            ]);

            if (empty($achievement_6)) {
                $achievement_6 = new Achievements();
                $achievement_6->main_id = $server->id;
                $achievement_6->main_type = Achievements::MAIN_TYPE_SERVER;
                $achievement_6->achievement_id = 6;
                return $achievement_6->save();
            }
        }

        if ($server->players >= 1000 && !$server->hasAchievement(7)) {
            $achievement_7 = Achievements::findOne([
                'main_id' => $server->id,
                'main_type' => Achievements::MAIN_TYPE_SERVER,
                'achievement_id' => 7
            ]);

            if (empty($achievement_7)) {
                $achievement_7 = new Achievements();
                $achievement_7->main_id = $server->id;
                $achievement_7->main_type = Achievements::MAIN_TYPE_SERVER;
                $achievement_7->achievement_id = 7;
                return $achievement_7->save();
            }
        }
    }

    public function _updateStatistic($server)
    {
        $statistic = new ServersStatistic();
        $statistic->server_id = $server->id;
        $statistic->players = $server->players;
        $statistic->save(false);

        $lastDay = strtotime(date('Y-m-d H:m:s')) - 86400;
        $statisticDaily = ServersStatisticMonth::find()
            ->where(['server_id' => $server->id])
            ->andWhere(['>', 'date', date('Y-m-d H:m:s', $lastDay)])
            ->one();

        if (empty($statisticDaily)) {
            $statisticDaily = new ServersStatisticMonth();
            $statisticDaily->server_id = $server->id;
        }

        $lastStatistic = ServersStatistic::find()
            ->where(['server_id' => $server->id])
            ->andWhere(['>', 'date', date('Y-m-d H:m:s', $lastDay)])
            ->all();

        $averageOnline = 0;
        $maximumOnline = 0;

        foreach ($lastStatistic AS $one) {
            if ($one->players > $maximumOnline) {
                $maximumOnline = $one->players;
            }

            $averageOnline += $one->players;
        }

        if ($averageOnline > 0) {
            $averageOnline = round($averageOnline / count($lastStatistic));
        }

        $statisticDaily->average_online = $averageOnline;
        $statisticDaily->maximum_online = $maximumOnline;

        $server->average_online = $averageOnline;
        $server->maximum_online = $maximumOnline;
        $server->save(false);

        $statisticDaily->save(false);
    }
}