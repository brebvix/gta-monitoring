<?php
namespace frontend\modules\telegram\controllers;

use frontend\modules\telegram\models\TelegramApi;
use frontend\modules\telegram\models\TelegramServersRelations;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;
use frontend\modules\telegram\models\TelegramUser;
use Yii;

class AddserverController
{
    public function actionIndex(Api $telegram, Update $webHook, $command, TelegramUser $user)
    {
        $message = Yii::t('main', 'Сервер не найден.');

        if (isset($command[1])) {
            $addServerStatus = TelegramServersRelations::addServer($user, $command[1]);

            if ($addServerStatus) {
                $message = Yii::t('main', 'Вы успешно добавили сервер в избранное.');
            }
        }

        $telegram->sendMessage(TelegramApi::formatMessage($webHook->getChat()->getId(), $message));
    }
}