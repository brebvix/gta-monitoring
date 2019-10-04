<?php

namespace frontend\modules\telegram\controllers;

use common\models\Servers;
use common\models\ServersStatisticMonth;
use frontend\modules\telegram\models\TelegramApi;
use frontend\modules\telegram\models\TelegramServersRelations;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;
use frontend\modules\telegram\models\TelegramUser;
use Yii;
use yii\helpers\Url;
use common\models\PlayersRelations;

class StatisticController
{
    public function actionIndex(Api $telegram, Update $webHook, $command, TelegramUser $user)
    {
        $message = '';

        $relations = TelegramServersRelations::find()
            ->where(['telegram_user_id' => $user->id])
            ->with('server')
            ->all();

        foreach ($relations AS $relation) {
            $server = $relation->server;
            if ($server->status == Servers::STATUS_ACTIVE) {
                $message .= hex2bin('E29C85');
            } else {
                $message .= hex2bin('E29D97');
            }

            $message .= ' #' . $server->id . ' <a href="https://servers.fun' . Url::to(['/server/view', 'id' => $server->id, 'title_eng' => $server->title_eng, 'game' => $server->game()]) . '">' . $server->title . '</a> ';

            if ($server->status == Servers::STATUS_ACTIVE) {
                $message .= "[{$server->players} / {$server->maxplayers}]";
            } else {
                $message .= hex2bin('E29D8C') . ' ' . Yii::t('main', 'Выключен') . hex2bin('E29D8C');
            }

            $message .= PHP_EOL;

            $statistics = ServersStatisticMonth::find()
                ->where(['server_id' => $server->id])
                ->orderBy(['id' => SORT_DESC])
                ->limit(30)
                ->all();

            $count = 0;

            $data = [
                'average' => [
                    'day' => 0,
                    'week' => 0,
                    'month' => 0,
                ],
                'maximum' => [
                    'day' => 0,
                    'week' => 0,
                    'month' => 0,
                ],
                'count' => [
                    'day' => 0,
                    'week' => 0,
                    'month' => 0,
                ]
            ];

            foreach ($statistics AS $statistic) {
                $count++;

                if ($count <= 1) {
                    $data['average']['day'] = $statistic->average_online;
                    $data['maximum']['day'] = $statistic->maximum_online;
                }

                if ($count <= 7) {
                    $data['average']['week'] += $statistic->average_online;
                    $data['count']['week']++;

                    if ($statistic->maximum_online > $data['maximum']['week']) {
                        $data['maximum']['week'] = $statistic->maximum_online;
                    }
                }

                $data['average']['month'] += $statistic->average_online;
                $data['count']['month']++;

                if ($statistic->maximum_online > $data['maximum']['month']) {
                    $data['maximum']['month'] = $statistic->maximum_online;
                }
            }

            if ($data['average']['week'] > 0 && $data['count']['week'] > 0) {
                $data['average']['week'] = round($data['average']['week'] / $data['count']['week']);
            }

            if ($data['average']['month'] > 0 && $data['count']['month'] > 0) {
                $data['average']['month'] = round($data['average']['month'] / $data['count']['month']);
            }

            $message .= hex2bin('E29C94') . Yii::t('main', 'Средний онлайн за сегодня: ')
                . '<b>' . $data['average']['day'] . '</b>';
            $message .= PHP_EOL;
            $message .= hex2bin('E29C94') . Yii::t('main', 'Максимальный онлайн за сегодня: ')
                . '<b>' . $data['maximum']['day'] . '</b>';
            $message .= PHP_EOL;
            $message .= hex2bin('E29C94') . Yii::t('main', 'Средний онлайн за неделю: ')
                . '<b>' . $data['average']['week'] . '</b>';
            $message .= PHP_EOL;
            $message .= hex2bin('E29C94') . Yii::t('main', 'Максимальный онлайн за неделю: ')
                . '<b>' . $data['maximum']['week'] . '</b>';
            $message .= PHP_EOL;
            $message .= hex2bin('E29C94') . Yii::t('main', 'Средний онлайн за месяц: ')
                . '<b>' . $data['average']['month'] . '</b>';
            $message .= PHP_EOL;
            $message .= hex2bin('E29C94') . Yii::t('main', 'Максимальный онлайн за месяц: ')
                . '<b>' . $data['maximum']['month'] . '</b>';
            $message .=
                PHP_EOL .
                hex2bin('C2A9') . hex2bin('C2A9') . hex2bin('C2A9') .
                '<a href="https://servers.fun">Servers.Fun</a>' .
                hex2bin('C2A9') . hex2bin('C2A9') . hex2bin('C2A9') .
                PHP_EOL . PHP_EOL;
        }

        $telegram->sendMessage(TelegramApi::formatMessage($webHook->getChat()->getId(), $message));
    }
}