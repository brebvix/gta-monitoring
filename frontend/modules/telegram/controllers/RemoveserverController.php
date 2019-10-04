<?php
namespace frontend\modules\telegram\controllers;

use common\models\Servers;
use frontend\modules\telegram\models\TelegramApi;
use frontend\modules\telegram\models\TelegramMessages;
use frontend\modules\telegram\models\TelegramServersRelations;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;
use frontend\modules\telegram\models\TelegramUser;
use Yii;

class RemoveserverController
{
    public function actionIndex(Api $telegram, Update $webHook, $command, TelegramUser $user)
    {
        $message = Yii::t('main', 'Сервер не найден.');

        if (isset($command[1])) {
            $removeServerStatus = TelegramServersRelations::deleteServer($user, $command[1]);

            if ($removeServerStatus) {
                $message = Yii::t('main', 'Вы успешно убрали сервер из избранного.');
            }
        }

        $telegram->sendMessage(TelegramApi::formatMessage($webHook->getChat()->getId(), $message));
    }
}