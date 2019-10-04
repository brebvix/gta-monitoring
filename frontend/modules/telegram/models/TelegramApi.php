<?php

namespace frontend\modules\telegram\models;

use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Api;

class TelegramApi
{
    public static function getMainObject()
    {
        return new Api('KEY_HERE');
    }

    public static function formatButton($array)
    {
        $resultKeyboard = [];

        foreach ($array AS $key => $value) {
            $resultKeyboard[] = [[
                'text' => $value,
                'callback_data' => $key,
            ]];
        }

        return json_encode([
            'inline_keyboard' => $resultKeyboard
        ]);
    }

    public static function formatMessage($chat_id, $message, $buttons = false)
    {
        $resultArray = [
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'html',
        ];

        if (is_array($buttons)) {
            $resultArray['reply_markup'] = self::formatButton($buttons);
        }

        //var_dump($resultArray);
        return $resultArray;
    }

    public static function sendBigMessage(Api $telegram, $chatId, $message)
    {
        $result = [];

        while (strlen($message) > 3900) {
            $result[] = substr($message, 0, 3900);
            $message = substr($message, 3900);
        }

        $result[] = $message;

        if (count($result) > 1) {
            foreach ($result AS $one) {
                $telegram->sendMessage(self::formatMessage($chatId, $one));
                sleep(1);
            }

            return true;
        } else {
            return $telegram->sendMessage(self::formatMessage($chatId, $message));
        }
    }
}
