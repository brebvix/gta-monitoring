<?php

namespace frontend\modules\telegram\controllers;

use frontend\modules\telegram\models\TelegramMessages;
use frontend\modules\telegram\models\TelegramServersRelations;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;
use Yii;
use yii\base\Controller;
use frontend\modules\telegram\models\TelegramApi;

class StartController extends Controller
{
    public function actionIndex(Api $telegram, Update $webHook, $command, $user)
    {
        $telegram->sendMessage(TelegramMessages::chooseLanguage($webHook));

        if (isset($command[1])) {
            TelegramServersRelations::addServer($user, $command[1]);
        }

        $message = Yii::t('main', 'Используйте /help для получения списка доступных команд.');

        $telegram->sendMessage(TelegramApi::formatMessage($webHook->getChat()->getId(), $message));
    }
}