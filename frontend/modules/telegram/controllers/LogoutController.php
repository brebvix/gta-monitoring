<?php

namespace frontend\modules\telegram\controllers;

use frontend\modules\telegram\models\TelegramApi;
use frontend\modules\telegram\models\TelegramServersRelations;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;
use frontend\modules\telegram\models\TelegramUser;
use Yii;
use common\models\User;

class LogoutController
{
    public function actionIndex(Api $telegram, Update $webHook, $command, TelegramUser $user)
    {
        $mainUser = User::findOne(['telegram_user_id' => $user->telegram_user_id, 'telegram_status' => User::TELEGRAM_STATUS_ENABLED]);

        if (empty($mainUser)) {
            $message = Yii::t('main', 'Аккаунт не найден или он не использует привязку к Telegram.');

            $telegram->sendMessage(TelegramApi::formatMessage($webHook->getChat()->getId(), $message));

            return true;
        }

        $mainUser->telegram_status = User::TELEGRAM_STATUS_DISABLED;
        $mainUser->save();

        $user->user_id = -1;
        $user->save();

        $message = Yii::t('main', 'Вы успешно отвязали Telegram от аккаунта') . ' ' . $mainUser->username . '.';

        $telegram->sendMessage(TelegramApi::formatMessage($webHook->getChat()->getId(), $message));
    }
}