<?php

use yii\helpers\Url;

$this->title = Yii::t('main', 'Telegram бот') . ' @ServersFun_bot';

Yii::$app->params['breadcrumbs'][] = Yii::t('main', 'Помощь');
Yii::$app->params['breadcrumbs'][] = Yii::t('main', 'Telegram бот');

Yii::$app->params['description'] = Yii::t('main', 'Описание всех функций telegram бота ServersFun_bot.');

$this->registerJsFile('/js/page_help_telegram_bot.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/highlight/highlight.pack.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerCssFile('/js/plugins/highlight/styles/default.css');

$this->registerJs('hljs.initHighlightingOnLoad();', 3);
?>
<div class="row">
    <div class="col-lg-3 col-xlg-3 col-md-4">
        <div class="card stickyside inbox-panel">
            <div class="list-group" id="top-menu">
                <a href="#1" class="list-group-item"><?= Yii::t('main', 'Основная информация') ?></a>
                <a href="#2" class="list-group-item"><?= Yii::t('main', '/help') ?></a>
                <a href="#3" class="list-group-item"><?= Yii::t('main', '/addserver') ?></a>
                <a href="#4" class="list-group-item"><?= Yii::t('main', '/auth') ?></a>
                <a href="#5" class="list-group-item"><?= Yii::t('main', '/language') ?></a>
                <a href="#6" class="list-group-item"><?= Yii::t('main', '/logout') ?></a>
                <a href="#7" class="list-group-item"><?= Yii::t('main', '/players') ?></a>
                <a href="#8" class="list-group-item"><?= Yii::t('main', '/removeserver') ?></a>
                <a href="#9" class="list-group-item"><?= Yii::t('main', '/statistic') ?></a>
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-xlg-9 col-md-8">
        <div class="card" id="1">
            <div class="card-body">
                <h4 class="card-title"><?= Yii::t('main', 'Основная информация') ?></h4>
                <p><?= Yii::t('main', 'Для начала работы с ботом вам достаточно перейти по этой ссылке') ?>: <a
                            href="https://t.me/ServersFun_bot" target="_blank">@ServersFun_bot</a>.</p>
                <p><?= Yii::t('main', 'На данный момент бот обладает таким функционалом:') ?></p>
                <ul>
                    <li><?= Yii::t('main', 'Актуальной статистика сервера') ?>;</li>
                    <li><?= Yii::t('main', 'Информация о игроках Online') ?>;</li>
                    <li><?= Yii::t('main', 'Мультиязычность (Русский, Английский)') ?>;</li>
                    <li><?= Yii::t('main', 'Подключение Telegram к аккаунту на сайте') ?>;</li>
                    <li><?= Yii::t('main', 'Синхронизация списка избранных серверов в Telegram и на сайте (<i>при условии подключенияаккаунта к Telegram</i>), а так же возможность управлять общим списком серверов как на сайте, так и с помощью бота.') ?>;</li>
                    <li><?= Yii::t('main', 'Мгновенное получение важных уведомлений из сайта в Telegram (<i>при условии подключения аккаунтак Telegram</i>)') ?>;</li>
                    <li><?= Yii::t('main', 'Уведомление при недоступности сервера') ?>.</li>
                </ul>
            </div>
        </div>

        <div class="card" id="2">
            <div class="card-body">
                <h4 class="card-title"><?= Yii::t('main', 'Команда') ?> /help</h4>
                <code>/help</code>
                <?= Yii::t('main', 'Возвращает список доступных команд, включая их описание и необходимые параметры.') ?>
            </div>
        </div>

        <div class="card" id="3">
            <div class="card-body">
                <h4 class="card-title"><?= Yii::t('main', 'Команда') ?> /addserver</h4>
                <code>/addserver <strong class="text-primary">&lt;IDENTIFIER&gt;</strong></code>
                (<?= Yii::t('main', 'где') ?> <strong class="text-primary">&lt;IDENTIFIER&gt;</strong>
                - <?= Yii::t('main', 'ID сервера в мониторинге или') ?>
                IP:PORT)<br>
                <?= Yii::t('main', 'Добавляет сервер в избранное (если установлена связь между Telegram и аккаунтом на сайте - так же добавляет в список избранных серверов на сайте).') ?>
            </div>
        </div>

        <div class="card" id="4">
            <div class="card-body">
                <h4 class="card-title"><?= Yii::t('main', 'Команда') ?> /auth</h4>
                <code>/auth <strong class="text-primary">&lt;CODE&gt;</strong></code> (<?= Yii::t('main', 'где') ?>
                <strong class="text-primary">&lt;CODE&gt;</strong>
                - <?= Yii::t('main', 'код полученный в настройках аккаунта') ?><br>
                <?= Yii::t('main', 'Инициализирует связь между Telegram и аккаунтом на сайте. Для использования необходимо иметь специальный код, который можно получить в') ?>
                <a
                        href="<?= !Yii::$app->user->isGuest ? Url::to(['/user/profile', 'id' => Yii::$app->user->id]) : '#' ?>
                    "><?= Yii::t('main', 'настройках') ?></a>
                <?= Yii::t('main', 'аккаунта.') ?>
            </div>
        </div>

        <div class="card" id="5">
            <div class="card-body">
                <h4 class="card-title"><?= Yii::t('main', 'Команда') ?> /language</h4>
                <code>/language</code> <?= Yii::t('main', 'Запускает установку языка общения бота, на выбор представлены русский и английский языки.') ?>
            </div>
        </div>

        <div class="card" id="6">
            <div class="card-body">
                <h4 class="card-title"><?= Yii::t('main', 'Команда') ?> /logout</h4>
                <code>/logout</code> <?= Yii::t('main', 'Отменяет связь между Telegram и аккаунтом на сайте, уведомления так же больше не будут приходить.') ?>
            </div>
        </div>

        <div class="card" id="7">
            <div class="card-body">
                <h4 class="card-title"><?= Yii::t('main', 'Команда') ?> /players</h4>
                <code>/players</code> <?= Yii::t('main', 'Возвращает список игроков на серверах, которые были добавлены в избранное.') ?>
            </div>
        </div>

        <div class="card" id="8">
            <div class="card-body">
                <h4 class="card-title"><?= Yii::t('main', 'Команда') ?> /removeserver</h4>
                <code>/removeserver <strong class="text-primary">&lt;IDENTIFIER&gt;</strong></code>
                (где <strong class="text-primary">&lt;IDENTIFIER&gt;</strong>
                - <?= Yii::t('main', 'ID сервера в мониторинге или') ?>
                IP:PORT)<br>
                <?= Yii::t('main', 'Удаляет сервер из избранного (если установлена связь между Telegram и аккаунтом на сайте - так же удаляет из списка избранных серверов на сайте).') ?>
            </div>
        </div>

        <div class="card" id="9">
            <div class="card-body">
                <h4 class="card-title"><?= Yii::t('main', 'Команда') ?> /statistic</h4>
                <code>/statistic</code> <?= Yii::t('main', 'Возвращает статистику серверов в избранном, включая:') ?>
                <ul>
                    <li><?= Yii::t('main', 'Средний онлайн за 24 часа, неделю, месяц') ?>;</li>
                    <li><?= Yii::t('main', 'Максимальный онлайн за 24 часа, неделю, месяц') ?>.</li>
                </ul>
            </div>
        </div>
    </div>
</div>