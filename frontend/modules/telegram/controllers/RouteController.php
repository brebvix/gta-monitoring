<?php

namespace frontend\modules\telegram\controllers;

use frontend\modules\telegram\models\TelegramApi;
use frontend\modules\telegram\models\TelegramUser;
use Telegram\Bot\Objects\Update;
use yii\web\Controller;
use Yii;
use Telegram\Bot\Api;

class RouteController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $telegram = TelegramApi::getMainObject();

        $webHook = $telegram->getWebhookUpdate();

        $message = $webHook->getMessage();

        if (!empty($message)) {
            $command = explode(' ', $message->getText());

            if (mb_substr($command[0], 0, 1, 'UTF-8') == '/') {
                $commandName = ucfirst(mb_substr($command[0], 1));
                $this->_runCommand($telegram, $webHook, $commandName, $command);
            }
        } else {
            $callback = $webHook->getCallbackQuery();

            if (!empty($callback)) {
                $command = explode(' ', $callback->getData());

                if (mb_substr($command[0], 0, 1, 'UTF-8') == '/') {
                    $commandName = ucfirst(mb_substr($command[0], 1));
                    $this->_runCommand($telegram, $webHook, $commandName, $command);
                }
            }
        }
    }

    private function _runCommand(Api $telegram, Update $webHook, $commandName, $args)
    {
        unset($args[0]);

        $namespace = 'frontend\modules\telegram\controllers\\' . $commandName . 'Controller';

        if (!empty($webHook->getMessage())) {
            $userObject = $webHook->getMessage()->getFrom();
        } else {
            $userObject = $webHook->getCallbackQuery()->getFrom();
        }

        $userModel = TelegramUser::findOne([
            'telegram_user_id' => $userObject->getId(),
            'chat_id' => $webHook->getChat()->getId()
        ]);
        if (empty($userModel)) {
            $userModel = new TelegramUser();
            $userModel->telegram_user_id = $userObject->getId();
            $userModel->chat_id = $webHook->getChat()->getId();
            $userModel->username = $userObject->getUsername();
            $userModel->first_name = $userObject->getFirstName();
            $userModel->language = 'ru';
            $userModel->save();
        }

        Yii::$app->language = $userModel->language == 'ru' ? 'ru-RU' : 'en-US';

        if (class_exists($namespace)) {
            $object = new $namespace($commandName . 'Controller', $this->module);
            $object->actionIndex($telegram, $webHook, $args, $userModel);
        } else {
            $telegram->sendMessage([
                'chat_id' => $webHook->getChat()->getId(),
                'text' => Yii::t('main', 'Комманда /{command} не найдена. Используйте /help для получения всех доступных комманд.', ['command' => strtolower($commandName)]),
            ]);
        }
    }
}