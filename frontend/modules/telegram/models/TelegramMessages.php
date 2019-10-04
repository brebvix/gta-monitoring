<?php
namespace frontend\modules\telegram\models;

class TelegramMessages
{
    public static function chooseLanguage($webHook)
    {
        return TelegramApi::formatMessage(
            $webHook->getChat()->getId(),
            'Выберите язык ' . PHP_EOL . PHP_EOL . ' Choose language',
            [
                '/language ru' => 'Русский',
                '/language en' => 'English',
            ]
        );
    }
}