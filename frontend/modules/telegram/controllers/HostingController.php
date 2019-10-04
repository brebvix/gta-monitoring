<?php

namespace frontend\modules\telegram\controllers;

use frontend\modules\telegram\models\TelegramApi;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;
use frontend\modules\telegram\models\TelegramUser;
use Yii;
use frontend\modules\hosting\models\HostingServers;

class HostingController
{

    public function actionIndex(Api $telegram, Update $webHook, $command, TelegramUser $user)
    {
        $buttons = false;

        if ($user->user_id > 0) {
            $servers = HostingServers::find()
                ->with('location')
                ->with('game')
                ->where(['user_id' => $user->user_id])
                ->all();

            if (count($servers) > 0) {
                $message = Yii::t('main', 'Выберите сервер для продолжения:');
                $buttons = [];
                foreach ($servers AS $server) {
                    $buttons['/server ' . $server->id] = '#' . $server->id . ') ' . $server->location->ip . ':' . $server->port . ' [' . $server->game->short . ']';
                }
            } else {
                $message = Yii::t('main', 'Игровые сервера не найдены, для аренды перейдите на сайт в раздел "Хостинг".');
            }
        } else {
            $message = Yii::t('main', 'Для использования функционала хостинга соедините Telegram с аккаунтом на сайте.');
        }

        $telegram->sendMessage(TelegramApi::formatMessage($webHook->getChat()->getId(), $message, $buttons));
    }
}