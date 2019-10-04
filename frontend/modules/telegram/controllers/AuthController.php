<?php

namespace frontend\modules\telegram\controllers;

use frontend\modules\telegram\models\TelegramApi;
use frontend\modules\telegram\models\TelegramServersRelations;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;
use frontend\modules\telegram\models\TelegramUser;
use Yii;
use common\models\User;

class AuthController
{
    public function actionIndex(Api $telegram, Update $webHook, $command, TelegramUser $user)
    {
        if (!isset($command[1])) {
            $message = Yii::t('main', 'Для подтверждения аккаунта отправьте ваш код через пробел, после команды.');

            $telegram->sendMessage(TelegramApi::formatMessage($webHook->getChat()->getId(), $message));

            return true;
        }

        $mainUser = User::findOne(['telegram_user_id' => $command[1]]);

        if (empty($mainUser)) {
            $message = Yii::t('main', 'Код не найден в системе. Перейдите в <a href="https://servers.fun/">настройки</a> и попробуйте еще раз.');

            $telegram->sendMessage(TelegramApi::formatMessage($webHook->getChat()->getId(), $message));

            return true;
        }

        $settingsLink = 'https://servers.fun/user/profile?id=' . $mainUser->id . '&type=settings';


        switch ($mainUser->telegram_status) {
            case User::TELEGRAM_STATUS_DISABLED:
                $message = Yii::t('main', 'Для привязки аккаунта авторизуйтесь на сайте и перейдите раздел <a href="{link}">настройки</a>.', ['link' => $settingsLink]);
                break;
            case User::TELEGRAM_STATUS_WAIT:
                if ($mainUser->telegram_user_id == $command[1]) {
                    $mainUser->telegram_user_id = $user->telegram_user_id;
                    $mainUser->telegram_status = User::TELEGRAM_STATUS_ENABLED;
                    $mainUser->save();

                    $user->user_id = $mainUser->id;
                    $user->save();

                    TelegramServersRelations::synchronize($mainUser, $user);

                    $message = Yii::t('main', 'Вы успешно привязали telegram к аккаунту {username}.', ['username' => $mainUser->username]);
                } else {
                    $message = Yii::t('main', 'К сожалению вы ввели неправильный код =(')
                        . PHP_EOL .
                        Yii::t('main', 'Перейдите в раздел <a href="{link}">настройки</a>, что бы получить правильный код подтверждения.', [
                        'link' => $settingsLink,
                    ]);
                }
                break;
            case User::TELEGRAM_STATUS_ENABLED:
                $message = Yii::t('main', 'Вы уже подключили свой telegram к аккаунту, используйте /logout для отмены связи.');
                break;
        }

        $telegram->sendMessage(TelegramApi::formatMessage($webHook->getChat()->getId(), $message));
    }
}