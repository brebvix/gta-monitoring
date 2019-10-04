<?php

namespace console\controllers;

set_time_limit(0);

use common\models\AdvertisingBannersBuy;
use common\models\ServersRating;
use common\models\ServersRatingStatistic;
use common\models\ServersStatistic;
use common\models\ServersStatisticMonth;
use common\models\ServersVip;
use common\models\System;
use common\models\UserNotifications;
use frontend\controllers\FrontCronController;
use frontend\modules\developer\models\Questions;
use yii\console\Controller;
use common\models\User;
use common\models\Servers;
use common\models\AdvertisingBanners;
use common\models\AdvertisingLinks;
use yii\helpers\HtmlPurifier;
use yii\helpers\Json;

class CronController extends Controller
{
    public $site_host = 'https://servers.fun';

    public function actionUpdateServers()
    {
        System::updateGlobalStatisticFinal();

        System::updateGlobalStatistic('servers_online', 0, false);
        System::updateGlobalStatistic('players_online', 0, false);

        $this->curl_request_async($this->site_host . '/front-cron/update-servers?start=0');
        $this->curl_request_async($this->site_host . '/front-cron/update-mta-servers');
        $this->curl_request_async($this->site_host . '/front-cron/update-rage-servers');

        $this->actionUpdateServersList();
        $this->actionUpdateFivemServers();

        $serversCount = Servers::find()->select('id')->count();
        System::updateGlobalStatistic('servers_count', $serversCount, false);
    }

    public function actionDisableOfflineServers()
    {
        $lastDay = strtotime(date('Y-m-d H:m:s')) - 10800;
        $servers = Servers::find()
            ->where(['<', 'created_at', date('Y-m-d H:m:s', $lastDay)])
            ->andWhere(['status' => Servers::STATUS_ACTIVE])
            ->all();


        foreach ($servers AS $server) {
            $server->status = 0;
            $server->save();
        }

        echo 'Disabled ' . count($servers) . ' servers';
    }

    public function actionUpdateRating()
    {
        $topServers = [];

        /**
         * @var Servers[] $servers
         */
        $servers = Servers::find()
            ->where(['status' => Servers::STATUS_ACTIVE])
            ->with('lastStatistic')
            ->all();

        foreach ($servers AS $server) {
            $statistic = $server->lastStatistic;
            if (isset($statistic[0], $statistic[1])) {
                echo PHP_EOL . "[server #{$server->id}] ";
                echo "[Average: {$statistic[1]->average_online}=>{$statistic[0]->average_online}, ";

                if ($statistic[0]->average_online > 0 && $statistic[0]->average_online > $statistic[1]->average_online) {
                    echo '+0.05';
                    $server->rating_up += 0.06;
                } else if ($statistic[0]->average_online < 0 || $statistic[0]->average_online < $statistic[1]->average_online) {
                    echo '-0.025';
                    $server->rating_down += 0.03;
                } else {
                    $server->rating_down += 0.015;
                    echo '-0.01';
                }

                echo ']';

                echo " [Maximum: {$statistic[1]->maximum_online}=>{$statistic[0]->maximum_online}, ";
                if ($statistic[0]->maximum_online > 0 && $statistic[0]->maximum_online > $statistic[1]->maximum_online) {
                    echo '+0.1';
                    $server->rating_up += 0.1;
                } else if ($statistic[0]->maximum_online < 0 || $statistic[0]->maximum_online < $statistic[1]->maximum_online) {
                    echo '-0.05';
                    $server->rating_down += 0.05;
                } else  {
                    $server->rating_down += 0.01;
                    echo '-0.01';
                }

                echo ']';

                $oldRating = $server->rating;
                echo ' [RATING: ' . number_format($server->rating, 3, '.', '.') . '=>';
                $server->rating = ServersRating::calculateByWilson($server->rating_up, $server->rating_down) * 10;
                echo number_format($server->rating, 3, '.', '') . '; ';
                echo "up: {$server->rating_up}, down: {$server->rating_down}]";
                $server->save();

                $differenceRating = $server->rating - $oldRating;

                $lastTransaction = ServersRatingStatistic::find()
                    ->where(['server_id' => $server->id])
                    ->orderBy(['id' => SORT_DESC])
                    ->limit(1)
                    ->one();

                if (!empty($lastTransaction)) {
                    $views = $server->views - $lastTransaction->views;

                    if (!isset($topServers[$server->game_id])) {
                        $topServers[$server->game_id] = ['server_id' => 0, 'rating' => 0];
                    }

                    if ($differenceRating > 0) {
                        if ($differenceRating > $topServers[$server->game_id]['rating']) {
                            $topServers[$server->game_id] = [
                                'server_id' => $server->id,
                                'rating' => $differenceRating
                            ];
                        }
                    }
                } else {
                    $views = $server->views;
                }

                $rating = new ServersRatingStatistic();
                $rating->server_id = $server->id;
                $rating->rating = $server->rating;
                $rating->views = $views;
                $rating->save();
            }
        }

        Servers::updateAll(['top' => Servers::TOP_NO], ['top' => Servers::TOP_YES]);

        foreach ($topServers AS $game_id => $serverData) {
            Servers::updateAll(['top' => Servers::TOP_YES], ['id' => $serverData['server_id']]);
        }
    }

    public function actionGarrysServers() // Garry's Mod servers
    {

        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );


        //$list = json_decode(file_get_contents('https://api.steampowered.com/IGameServersService/GetServerList/v1/?key=C181461CDDAF1DD67A2FC063486F40B9&filter=appid\4000&limit=100000', false, stream_context_create($arrContextOptions)), true);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.steampowered.com/IGameServersService/GetServerList/v1/?key=C181461CDDAF1DD67A2FC063486F40B9&filter=appid\4000&limit=100000');
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_FAILONERROR, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($curl, CURLOPT_POST, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        $data = curl_exec($curl);
        curl_close($curl);
        //var_dump($result);
        $result = Json::decode($this->convert_from_latin1_to_utf8_recursively($data));

        var_dump(count($result['response']['servers']));

        //file_put_contents('test.json',$data);
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

    public function actionUpdateFivemServers()
    {
        error_reporting(~0);
        ini_set('display_errors', 1);

        try {
            $server_list = file_get_contents('http://servers-live.fivem.net/api/servers/');
        } catch (\Exception $exception) {
            echo 'Getting servers error';
            return false;
        }

        $frontCron = new FrontCronController(0, 0);

        $playersOnline = 0;

        if (!$server_list) {
            echo 'Getting servers error';
            return false;
        }

        $server_list = json_decode($server_list, true);
        $count = count($server_list);

        for ($i = 0; $i < $count; $i++) {
            $addr = explode(':', $server_list[$i]['EndPoint']);

            try {
                $server = Servers::find()
                    ->select(['id', 'ip', 'port', 'players', 'game_id'])
                    ->where([
                        'ip' => $addr[0],
                        'port' => $addr[1],
                        'game_id' => 3,
                    ])
                    ->one();
            } catch (\Exception $exception) {
                $server = '';
            }

            if (empty($server)) {
                $server = new Servers();
                $server->ip = $addr[0];
                $server->port = (int)$addr[1];
                $server->game_id = 3;

                $server->rating = '2.54';
                $server->rating_up = 1;
                $server->rating_down = 0;
                $server->status = 1;
            }

            $server->players = (int)$server_list[$i]['Data']['clients'];

            $playersOnline += $server->players;

            $server->maxplayers = (int)$server_list[$i]['Data']['sv_maxclients'];
            $server->title = mb_substr(HtmlPurifier::process(mb_convert_encoding($server_list[$i]['Data']['hostname'], 'utf-8', mb_detect_encoding($server_list[$i]['Data']['hostname']))), 0, 128);
            $server->title_eng = Questions::translit($server->title);
            if (empty($server->title)) {
                $server->status = 0;
            } else {
                $server->status = 1;
            }
            $server->mode = HtmlPurifier::process($server_list[$i]['Data']['gamename']);
            $server->description = 'Resources: ' . substr(implode(', ', $server_list[$i]['Data']['resources']), 0, -2);
            $server->save(false);

            if (!empty($server_list[$i]['Data']['players'])) {
                $playerList = [];

                foreach ($server_list[$i]['Data']['players'] AS $onePlayer) {
                    $playerList[]['gq_name'] = $onePlayer['name'];
                }

                $frontCron->_updatePlayers($playerList, $server->id);
            }

            $frontCron->_updateStatistic($server);
        }

        System::updateGlobalStatistic('servers_online', $count);
        System::updateGlobalStatistic('players_online', $playersOnline);
    }

    public function actionUpdateOfflineServers()
    {
        $count = Servers::find()
            ->where(['status' => Servers::STATUS_OFFLINE])
            ->andWhere(['in', 'game_id', [1, 2]])
            ->count();

        $threads = ceil($count / 50);
        $url = $this->site_host . '/front-cron/update-servers?offline=true&start=';
        for ($i = 0; $i < $threads; $i++) {
            $this->curl_request_async($url . ($i * 50));
        }
    }

    public function curl_request_async($url)
    {
        $curl = curl_init();
        $post['test'] = 'examples daata'; // our data todo in received
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);

        curl_setopt($curl, CURLOPT_USERAGENT, 'api');

        curl_setopt($curl, CURLOPT_TIMEOUT, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 10);

        curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);

        curl_exec($curl);

        curl_close($curl);
    }

    public function actionUpdateCourse()
    {
        $course = json_decode(file_get_contents('https://api.cryptonator.com/api/ticker/usd-rur'));

        if (isset($course->ticker)) {
            if ($course->ticker->price > 0) {
                $system = System::findOne(['key' => 'course_rub']);
                $system->value = $course->ticker->price;
                $system->save();
            } else {
                echo 'UPDATE FAIL!';
            }
        }
    }

    public function actionUpdateServersList()
    {
        $list1 = @file_get_contents('http://monitor.sacnr.com/list/masterlist.txt');
        $list2 = @file_get_contents('http://lists.sa-mp.com/0.3.DL/internet');
        $list3 = @file_get_contents('http://lists.sa-mp.com/0.3.7/servers');
        $list4 = @file_get_contents('http://master.sampsrv.ru/cr03724/servers');
        $list5 = @file_get_contents('http://master.gtasrv.ru/crc/servers');

        $lines = array_merge(
            preg_split('/\\r\\n?|\\n/', $list1),
            preg_split('/\\r\\n?|\\n/', $list2),
            preg_split('/\\r\\n?|\\n/', $list3),
            preg_split('/\\r\\n?|\\n/', $list4),
            preg_split('/\\r\\n?|\\n/', $list5)
        );


        $count = count($lines);

        for ($i = 0; $i < $count; $i++) {
            $ip = explode(':', $lines[$i]);

            if (isset($ip[0], $ip[1])) {
                $check = Servers::find()->select(['id'])->where(['ip' => $ip[0], 'port' => (int)$ip[1]])->one();

                if (empty($check)) {
                    Servers::addServer($ip[0], (int)$ip[1], 1);
                }
            }
        }
    }

    public function actionCheckEnd()
    {
        $lastDay = strtotime(date('Y-m-d H:m:s')) - 86400;
        ServersStatistic::deleteAll(['<', 'date', date('Y-m-d H:m:s', $lastDay)]);
        ServersStatisticMonth::deleteAll(['<', 'date', date('Y-m-d H:m:s', strtotime(date('Y-m-d H:m:s')) - (86400 * 30))]);
        ServersRatingStatistic::deleteAll(['<', 'date', date('Y-m-d H:m:s', strtotime(date('Y-m-d H:m:s')) - (86400 * 30))]);

        $banners = AdvertisingBannersBuy::find()
            ->where(['status' => AdvertisingBannersBuy::STATUS_ACTIVE])
            ->all();

        foreach ($banners AS $banner) {
            if ((time() - strtotime($banner->date)) > ($banner->days * 24 * 60 * 60)) {
                $banner->status = AdvertisingBannersBuy::STATUS_NO_ACTIVE;
                $banner->save();

                $mainModel = AdvertisingBanners::findOne(['id' => $banner->banner_id]);
                $mainModel->status = AdvertisingBanners::STATUS_FREE;
                $mainModel->save();

                $user = User::findOne(['id' => $banner->user_id]);

                $notification = new UserNotifications();
                $notification->user_id = $user->id;
                $notification->type = UserNotifications::TYPE_END_BANNER;
                $notification->data = json_encode([
                    'username' => $user->username,
                    'banner_title' => $banner->title,
                    'banner_position' => $banner->id,
                    'banner_size' => $banner->banner->size,
                    'banner_days' => $banner->days,
                    'banner_clicks' => $banner->link->clicks,
                ]);

                $notification->save();
            }
        }

        $links = AdvertisingLinks::find()
            ->where(['status' => AdvertisingLinks::STATUS_ACTIVE])
            ->all();

        foreach ($links AS $link) {
            if ((time() - strtotime($link->date)) > ($link->days * 24 * 60 * 60)) {
                $link->status = AdvertisingLinks::STATUS_NO_ACTIVE;
                $link->save();

                $user = User::findOne(['id' => $link->user_id]);

                $notification = new UserNotifications();
                $notification->user_id = $user->id;
                $notification->type = UserNotifications::TYPE_END_LINK;
                $notification->data = json_encode([
                    'username' => $user->username,
                    'link_title' => $link->title,
                    'link_days' => $link->days,
                    'link_clicks' => $link->link->clicks,
                ]);

                $notification->save();
            }
        }

        $vipServers = ServersVip::find()
            ->where(['status' => ServersVip::STATUS_ACTIVE])
            ->all();

        foreach ($vipServers AS $vipServer) {
            if ((time() - strtotime($vipServer->date)) > ($vipServer->days * 24 * 60 * 60)) {
                $vipServer->status = ServersVip::STATUS_NO_ACTIVE;
                $vipServer->save();

                $server = Servers::findOne(['id' => $vipServer->server_id]);

                if ($vipServer->type == ServersVip::TYPE_TOP) {
                    $server->vip = 0;
                } else {
                    $server->background = '';
                }

                $server->save();

                $user = User::findOne(['id' => $vipServer->user_id]);

                $notification = new UserNotifications();
                $notification->user_id = $user->id;
                $notification->type = ($vipServer->type == ServersVip::TYPE_TOP) ? UserNotifications::TYPE_END_SERVER_TOP : UserNotifications::TYPE_END_SERVER_COLOR;
                $notification->data = json_encode([
                    'username' => $user->username,
                    'server_title' => $server->title,
                    'server_id' => $server->id,
                    'vip_days' => $vipServer->days,
                ]);

                $notification->save();
            }
        }
    }
}