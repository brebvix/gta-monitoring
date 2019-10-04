<?php
namespace frontend\modules\telegram\controllers;

use frontend\modules\telegram\models\TelegramMessages;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;
use frontend\modules\telegram\models\TelegramUser;

class LanguageController
{
    public function actionIndex(Api $telegram, Update $webHook, $command, TelegramUser $user)
    {
        if (empty($command)) {
            $telegram->sendMessage(TelegramMessages::chooseLanguage($webHook));
            return true;
        }

        if (in_array($command[1], ['ru', 'en'])) {
            $user->language = $command[1];
            $user->save();

            $telegram->editMessageText([
                'chat_id' => $webHook->getChat()->getId(),
                'message_id' => $webHook->getCallbackQuery()->getMessage()->getMessageId(),
                'text' => $user->language == 'ru' ? 'Вы успешно выбрали русский язык!' : 'You have successfully chosen the English language!',
            ]);
        }
    }
}