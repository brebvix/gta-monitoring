<?php

namespace frontend\modules\telegram\controllers;

use yii\helpers\Url;
use common\models\Servers;
use frontend\modules\telegram\models\TelegramApi;
use frontend\modules\telegram\models\TelegramMessages;
use frontend\modules\telegram\models\TelegramServersRelations;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;
use frontend\modules\telegram\models\TelegramUser;
use Yii;
use common\models\PlayersRelations;

class PlayersController
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

            $last30Min = strtotime(date('Y-m-d H:m:s')) - 1800;

            $playersRelations = PlayersRelations::find()
                ->where(['server_id' => $server->id])
                ->andWhere(['>=', 'date', date('Y-m-d H:m:s', $last30Min)])
                ->orderBy(['minutes' => SORT_DESC])
                ->with('player')
                ->all();

            if (count($playersRelations) > 0) {
                $i = 0;
                $message .= PHP_EOL . hex2bin('F09F91A5') . Yii::t('main', 'Игроки онлайн') . hex2bin('F09F91A5');

                foreach ($playersRelations AS $relation) {
                    $i++;
                    $message .= PHP_EOL . $i . ') ' . $relation->player->nickname . ', ' . Yii::$app->formatter->asDuration($relation->minutes * 60);
                }
            }

            $message .=
                PHP_EOL .
                hex2bin('C2A9') . hex2bin('C2A9') . hex2bin('C2A9') .
                '<a href="https://servers.fun">Servers.Fun</a>' .
                hex2bin('C2A9') . hex2bin('C2A9') . hex2bin('C2A9') .
                PHP_EOL . PHP_EOL;
        }

        TelegramApi::sendBigMessage($telegram, $webHook->getChat()->getId(), $message);
        //$telegram->sendMessage(TelegramApi::formatMessage($webHook->getChat()->getId(), $message));
    }
}