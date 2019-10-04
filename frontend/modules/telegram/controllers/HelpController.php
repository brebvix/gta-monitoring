<?php

namespace frontend\modules\telegram\controllers;

use frontend\modules\telegram\models\TelegramApi;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;
use frontend\modules\telegram\models\TelegramUser;
use Yii;

class HelpController
{
    private $_commands = [
        '/help' => 'Список доступных команд',
        '/addserver <i>IP:PORT</i>' => 'Добавить сервер в избранное',
        '/auth <i>CODE</i>' => 'Привязка Telegram к аккаунту на сайте',
        '/language' => 'Смена языка',
        '/logout' => 'Отвязка Telegram от аккаунта на сайте',
        '/players' => 'Общая информация и список игроков',
        '/removeserver <i>IP:PORT</i>' => 'Удалить сервер из избранного',
        '/statistic' => 'Полная статистика сервера',
    ];

    public function actionIndex(Api $telegram, Update $webHook, $command, TelegramUser $user)
    {
        $message = hex2bin('F09F92A1') . Yii::t('main', 'Список доступных команд') . hex2bin('F09F92A1');
        $message .= PHP_EOL;

        foreach ($this->_commands AS $command => $description) {
            $message .= hex2bin('E29C92') . $command . ' - ' . Yii::t('main', $description) . PHP_EOL;
        }

        $telegram->sendMessage(TelegramApi::formatMessage($webHook->getChat()->getId(), $message));
    }
}