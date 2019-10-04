<?php

namespace frontend\modules\telegram\controllers;

use frontend\modules\hosting\models\HostingGames;
use frontend\modules\hosting\models\Ssh;
use frontend\modules\telegram\models\TelegramApi;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;
use frontend\modules\telegram\models\TelegramUser;
use Yii;
use frontend\modules\hosting\models\HostingServers;

class ServerController
{

    public function actionIndex(Api $telegram, Update $webHook, $command, TelegramUser $user)
    {
        $buttons = false;
        $message = '';

        if ($user->user_id > 0 && isset($command[1])) {
            $server = HostingServers::find()
                ->with('location')
                ->with('game')
                ->where(['user_id' => $user->user_id, 'id' => (int)$command[1]])
                ->one();

            if (!empty($server)) {
                $message = '#' . $server->id . ') ' . $server->location->ip . ':' . $server->port . ' [' . $server->game->short . ']' . PHP_EOL . PHP_EOL;

                if (isset($command[2])) {
                    $ssh = new Ssh();
                    $ssh->connect($server->location);
                    $config = HostingGames::getBaseConfig($server, $server->location);

                    switch (strtolower($command[2])) {
                        case 'start':
                            $result = $ssh->action('server/start', [
                                'id' => 'fun' . $server->id,
                                'game_id' => $server->game_id,
                                'config' => json_encode($config)
                            ]);

                            if ($result == 'ok') {
                                $server->status = HostingServers::STATUS_ACTIVE;
                                $server->save();

                                $message .= Yii::t('main', 'Сервер успешно запущен.') . PHP_EOL . PHP_EOL;
                            } else {
                                $server->status = HostingServers::STATUS_NO_ACTIVE;
                                $server->save();

                                $message .= Yii::t('main', 'Ошибка запуска сервера, обратитесь в  поддержку.') . PHP_EOL . PHP_EOL;
                            }
                            break;
                        case 'stop':
                            $ssh->action('server/stop', [
                                'id' => 'fun' . $server->id
                            ]);

                            $server->status = HostingServers::STATUS_NO_ACTIVE;
                            $server->save();

                            $message .= Yii::t('main', 'Сервер успешно остановлен.') . PHP_EOL . PHP_EOL;

                            break;
                        case 'restart':
                            $result = $ssh->action('server/restart', [
                                'id' => 'fun' . $server->id,
                                'game_id' => $server->game_id,
                                'config' => json_encode($config)
                            ]);

                            if ($result == 'ok') {
                                $server->status = HostingServers::STATUS_ACTIVE;
                                $server->save();

                                $message .= Yii::t('main', 'Сервер успешно перезапущен.') . PHP_EOL . PHP_EOL;
                            } else {
                                $server->status = HostingServers::STATUS_NO_ACTIVE;
                                $server->save();

                                $message .= Yii::t('main', 'Ошибка перезапуска сервера, обратитесь в  поддержку.') . PHP_EOL . PHP_EOL;
                            }
                            break;
                        case 'ftp':
                            $message .= Yii::t('main', 'FTP доступы:') . PHP_EOL;
                            $message .= Yii::t('main', 'Сервер') . ': ' . $server->location->ip . PHP_EOL;
                            $message .= Yii::t('main', 'Имя пользователя') . ': fun' . $server->id . PHP_EOL;
                            $message .= Yii::t('main', 'Пароль') . ': ' . $server->ftp_password . PHP_EOL;
                            break;
                        case 'mysql':
                            $message .= Yii::t('main', 'MySQL доступы:') . PHP_EOL;
                            $message .= 'PHPMyAdmin' . ': http://' . $server->location->ip . '/phpmyadmin' . PHP_EOL;
                            $message .= Yii::t('main', 'Сервер') . ': ' . $server->location->ip . PHP_EOL;
                            $message .= Yii::t('main', 'Имя пользователя') . ': fun' . $server->id . PHP_EOL;
                            $message .= Yii::t('main', 'Пароль') . ': ' . $server->database_password . PHP_EOL;
                            break;
                    }
                } else {
                    $message .=
                        Yii::t('main', 'Статус') . ': ' .
                        ($server->status == HostingServers::STATUS_ACTIVE ?
                            Yii::t('main', 'Работает') :
                            Yii::t('main', 'Не работает'));
                    $message .= PHP_EOL;
                    $message .= Yii::t('main', 'Расположение') . ': ' . $server->location->title . PHP_EOL;
                    $message .= Yii::t('main', 'Нагрузка') . ' CPU: ' . $server->cpu_load . '%' . PHP_EOL;
                    $message .= Yii::t('main', 'Нагрузка') . ' RAM: ' . $server->ram_load . '%' . PHP_EOL;
                }

                $buttons = [
                    '/server ' . $server->id . ' start' => Yii::t('main', 'Запустить'),
                    '/server ' . $server->id . ' restart' => Yii::t('main', 'Перезагрузить'),
                    '/server ' . $server->id . ' stop' => Yii::t('main', 'Остановить'),
                    '/server ' . $server->id . ' ftp' => Yii::t('main', 'Получить доступы FTP'),
                    '/server ' . $server->id . ' mysql' => Yii::t('main', 'Получить доступы MySQL'),
                ];

            }
        } else {
            $message = Yii::t('main', 'Для использования функционала хостинга соедините Telegram с аккаунтом на сайте.');
        }

        $telegram->sendMessage(TelegramApi::formatMessage($webHook->getChat()->getId(), $message, $buttons));
    }
}