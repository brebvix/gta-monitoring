<?php
use yii\helpers\Url;

$this->title = Yii::t('main', 'API мониторинга');

Yii::$app->params['breadcrumbs'][] = Yii::t('main', 'Помощь');
Yii::$app->params['breadcrumbs'][] = 'API';

Yii::$app->params['description'] = Yii::t('main', 'Список всех функций API для получения информации о серверах и игроках.');

$this->registerJsFile('/js/page_help_api.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/highlight/highlight.pack.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerCssFile('/js/plugins/highlight/styles/default.css');

$this->registerJs('hljs.initHighlightingOnLoad();', 3);
?>
<div class="row">
    <div class="col-lg-3 col-xlg-3 col-md-4">
        <div class="card stickyside inbox-panel">
            <div class="list-group" id="top-menu">
                <a href="#1" class="list-group-item"><?= Yii::t('main' ,'Введение') ?></a>
                <a href="#2" class="list-group-item"><?= Yii::t('main' ,'Информация о сервере') ?></a>
                <a href="#3" class="list-group-item"><?= Yii::t('main' ,'Статистика сервера') ?></a>
                <a href="#4" class="list-group-item"><?= Yii::t('main' ,'Информация о игроках') ?></a>
                <a href="#5" class="list-group-item"><?= Yii::t('main' ,'Примеры использования') ?></a>
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-xlg-9 col-md-8">
        <div class="card" id="1">
            <div class="card-body">
                <h4 class="card-title"><?= Yii::t('main' ,'Введение') ?></h4>
                <p><?= Yii::t('main' ,'Для доступа к любому методу API используется уникальный идентификатор') ?> (<strong  class="text-primary">&lt;IDENTIFIER&gt;</strong>),
                <?= Yii::t('main' ,'он же') ?> - <span class="text-info"><?= Yii::t('main' ,'ID сервера') ?></span>, <?= Yii::t('main' ,'либо') ?> <span class="text-info"><?= Yii::t('main' ,'адрес сервера') ?></span> (IP:PORT).</p>
                <p><?= Yii::t('main' ,'Что бы узнать ID сервера воспользуйтесь поиском вверху страницы - введите название интересующего сервера, из предоставленного списка выберите нужный, и перейдите на страницу сервера.') ?>
 <?= Yii::t('main' ,'Открыв адресную строку Вы увидите URL похожий на этот') ?> "https://servers.fun/samp/absolut-roleplei-platinym-gta-samp_ru/<span class="text-primary strong">14370</span>", <?= Yii::t('main' ,'цифры в конце строки и есть') ?> <span class="text-info"><?= Yii::t('main' ,'ID сервера') ?></span>.</p>
                <hr>
                <p><?= Yii::t('main' ,'Для вызова API используется следующая структура:') ?> <code>https://servers.fun/api/&lt;METHOD&gt;/&lt;IDENTIFIER&gt;?&lt;PARAMS&gt;</code></p>
                <ul>
                    <li><code>&lt;METHOD&gt;</code> - <?= Yii::t('main' ,'метод API (см. примеры ниже)') ?>;</li>
                    <li><code>&lt;IDENTIFIER&gt;</code> - <?= Yii::t('main' ,'идентификатор сервера (см. выше)') ?>;</li>
                    <li><code>&lt;PARAMS&gt;</code> - <?= Yii::t('main' ,'параметры вызова метода (см. примеры ниже)') ?>.</li>
                </ul>

                <p class="font-18"><?= Yii::t('main' ,'Для более подробной информации воспользуйтесь одним из примером в') ?> <a href="#5"><?= Yii::t('main' ,'конце страницы') ?></a>.</p>
            </div>
        </div>
        <div class="card" id="2">
            <div class="card-body">
                <h3 class="card-title"><?= Yii::t('main' ,'Информация о сервере') ?></h3>
                <p><?= Yii::t('main' ,'Получение информации используя идентификатор сервера:') ?></p>
                <pre><code class="html">https://servers.fun/api/servers/<span
                                class="text-primary">&lt;IDENTIFIER&gt;</span>?<span
                                class="text-warning">forJavaScript</span>=true
<hr class="m-b-0 m-t-10">
&lt;!-- <?= Yii::t('main' ,'Примеры использования') ?>: --&gt;
https://servers.fun/api/servers/<span class="text-primary">14370</span>
https://servers.fun/api/servers/<span class="text-primary">95.213.255.83:7771</span>
https://servers.fun/api/servers/<span class="text-primary">14370</span>?<span class="text-warning">forJavaScript</span>=true
https://servers.fun/api/servers/<span class="text-primary">95.213.255.83:7771</span>?<span class="text-warning">forJavaScript</span>=true</code></pre>
                <p></p>
                <p class="font-14"><strong class="text-primary">&lt;IDENTIFIER&gt;</strong> - <?= Yii::t('main' ,'идентификатор сервера, которым может выступать') ?>
                    <span class="text-info"><?= Yii::t('main' ,'ID сервера') ?></span> <?= Yii::t('main' ,'в мониторинге или же его') ?> <span
                            class="text-info"><?= Yii::t('main' ,'адрес') ?></span> (IP:PORT);<br>
                    <strong class="text-warning">forJavaScript</strong> - <?= Yii::t('main' ,'возвращает данные в виде JavaScript переменой (см. пример в конце).') ?>
                </p>
                <hr>
                <h5><?= Yii::t('main' ,'Возвращаемые данные') ?>:</h5>
                <div style="overflow-y: auto">
                <table class="table table-sm stylish-table">
                    <thead>
                    <tr>
                        <td><?= Yii::t('main' ,'Имя') ?></td>
                        <td><?= Yii::t('main' ,'Тип данных') ?></td>
                        <td><?= Yii::t('main' ,'Пример') ?></td>
                        <td><?= Yii::t('main' ,'Описание') ?></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="strong">id</td>
                        <td class="italic">integer</td>
                        <td>14370</td>
                        <td><?= Yii::t('main' ,'Идентификатор') ?> (ID)</td>
                    </tr>
                    <tr>
                        <td class="strong">ip</td>
                        <td class="italic">string</td>
                        <td>95.213.255.83</td>
                        <td><?= Yii::t('main' ,'IP адрес') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">port</td>
                        <td class="italic">integer</td>
                        <td>7771</td>
                        <td><?= Yii::t('main' ,'Порт') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">title</td>
                        <td class="italic">string</td>
                        <td>Абсолют РолеПлей 1 | Платинум | GTA-SAMP.RU</td>
                        <td><?= Yii::t('main' ,'Заголовок сервера' )?></td>
                    </tr>
                    <tr>
                        <td class="strong">gamemode</td>
                        <td class="italic">string</td>
                        <td>Russia/RPG/RolePlay/RP</td>
                        <td><?= Yii::t('main' ,'Мод') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">language</td>
                        <td class="italic">string</td>
                        <td>Russian/Русский/русский</td>
                        <td><?= Yii::t('main' ,'Язык') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">version</td>
                        <td class="italic">string</td>
                        <td>0.3.7-R2</td>
                        <td><?= Yii::t('main' ,'Версия') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">site</td>
                        <td class="italic">string</td>
                        <td>www.gta-samp.ru</td>
                        <td><?= Yii::t('main' ,'Сайт') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">players</td>
                        <td class="italic">array</td>
                        <td>-</td>
                        <td><?= Yii::t('main' ,'Массив с информацией о игроках') ?></td>
                    </tr>
                    <tr>
                        <td class="strong"><span class="m-l-20">number</span></td>
                        <td class="italic">integer</td>
                        <td>902</td>
                        <td><?= Yii::t('main' ,'Количество игроков онлайн') ?></td>
                    </tr>
                    <tr>
                        <td class="strong"><span class="m-l-20">maximum</span></td>
                        <td class="italic">integer</td>
                        <td>1000</td>
                        <td><?= Yii::t('main' ,'Количество слотов') ?></td>
                    </tr>
                    <tr>
                        <td class="strong"><span class="m-l-20">averageNumber</span></td>
                        <td class="italic">integer</td>
                        <td>480</td>
                        <td><?= Yii::t('main' ,'Среднее количество игроков') ?></td>
                    </tr>
                    <tr>
                        <td class="strong"><span class="m-l-20">maximumNumber</span></td>
                        <td class="italic">integer</td>
                        <td>1000</td>
                        <td><?= Yii::t('main' ,'Максимальное количество игроков') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">game</td>
                        <td class="italic">array</td>
                        <td>-</td>
                        <td><?= Yii::t('main' ,'Массив с информацией о игре') ?></td>
                    </tr>
                    <tr>
                        <td class="strong"><span class="m-l-20">id</span></td>
                        <td class="italic">integer</td>
                        <td>1</td>
                        <td><?= Yii::t('main' ,'ID игры') ?></td>
                    </tr>
                    <tr>
                        <td class="strong"><span class="m-l-20">title</span></td>
                        <td class="italic">string</td>
                        <td>SAMP</td>
                        <td><?= Yii::t('main' ,'Название игры') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">rating</td>
                        <td class="italic">float</td>
                        <td>2.7</td>
                        <td><?= Yii::t('main' ,'Рейтинг') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">found</td>
                        <td class="italic">boolean</td>
                        <td>true</td>
                        <td><?= Yii::t('main' ,'Найден ли сервер') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">onlineStatus</td>
                        <td class="italic">boolean</td>
                        <td>true</td>
                        <td><?= Yii::t('main' ,'Онлайн ли сервер') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">createdAt</td>
                        <td class="italic">string</td>
                        <td>2018-09-17 21:55:09</td>
                        <td><?= Yii::t('main' ,'Дата добавления сервера в мониторинг') ?></td>
                    </tr>
                    </tbody>
                </table>
                </div>
                <hr>
                <h5><?= Yii::t('main' ,'Пример возвращаемых данных') ?>:</h5>
                <pre><code class="javascript">// <?= Yii::t('main' ,'Запрос') ?>: https://servers.fun/api/servers/14370
{
    "id": 14370,
    "ip": "95.213.255.83",
    "port": 7771,
    "title": "Абсолют РолеПлей 1 | Платинум | GTA-SAMP.RU",
    "gamemode": "Russia/RPG/RolePlay/RP",
    "language": "Russian/Русский/русский",
    "version": "0.3.7-R2",
    "site": "www.gta-samp.ru",
    "players": {
        "number": 902,
        "maximum": 1000,
        "averageNumber": 0,
        "maximumNumber": 0
    },
    "game": {
        "id": 1,
        "title": "SAMP"
    },
    "rating": 2.7,
    "found": true,
    "onlineStatus": true,
    "createdAt": "2018-09-17 21:55:09",
}</code></pre>
                <hr>
                <h5><?= Yii::t('main' ,'Пример возвращаемых данных') ?> #2:</h5>
                <pre><code class="javascript">// <?= Yii::t('main' ,'Запрос') ?>: https://servers.fun/api/servers/14370?forJavaScript=true
var server = JSON.parse('{
    "id": 14370,
    "ip": "95.213.255.83",
    "port": 7771,
    "title": "Абсолют РолеПлей 1 | Платинум | GTA-SAMP.RU",
    "gamemode": "Russia/RPG/RolePlay/RP",
    "language": "Russian/Русский/русский",
    "version": "0.3.7-R2",
    "site": "www.gta-samp.ru",
    "players": {
        "number": 902,
        "maximum": 1000,
        "averageNumber": 0,
        "maximumNumber": 0
    },
    "game": {
        "id": 1,
        "title": "SAMP"
    },
    "rating": 2.7,
    "found": true,
    "onlineStatus": true,
    "createdAt": "2018-09-17 21:55:09",
}');</code></pre>
            </div>
        </div>
        <div class="card" id="3">
            <div class="card-body">
                <h3 class="card-title"><?= Yii::t('main' ,'Статистика сервера') ?></h3>
                <p><?= Yii::t('main' ,'Получение статистики используя идентификатор сервера') ?>:</p>
                <pre><code class="html">https://servers.fun/api/statistics/<span
                                class="text-primary">&lt;IDENTIFIER&gt;</span>?<span class="text-warning">per</span>=(day/week/month)&<span
                                class="text-warning">forJavaScript</span>=true
<hr class="m-b-0 m-t-10">
&lt;!-- <?= Yii::t('main' ,'Примеры использования') ?>: --&gt;
https://servers.fun/api/statistics/<span class="text-primary">14370</span>?<span class="text-warning">per</span>=day
https://servers.fun/api/statistics/<span class="text-primary">95.213.255.83:7771</span>?<span class="text-warning">per</span>=week
https://servers.fun/api/statistics/<span class="text-primary">14370</span>?<span class="text-warning">per</span>=month&<span class="text-warning">forJavaScript</span>=true
https://servers.fun/api/statistics/<span class="text-primary">95.213.255.83:7771</span>?<span class="text-warning">per</span>=day&<span class="text-warning">forJavaScript</span>=true</code></pre>
                <p></p>
                <p class="font-14"><strong class="text-primary">&lt;IDENTIFIER&gt;</strong> - <?= Yii::t('main' ,'идентификатор сервера, которым может выступать') ?> <span class="text-info"><?= Yii::t('main' ,'ID сервера') ?></span> <?= Yii::t('main' ,'в мониторинге или же его') ?> <span
                            class="text-info"><?= Yii::t('main' ,'адрес') ?></span> (IP:PORT);<br>
                    <strong class="text-warning">per</strong> - <?= Yii::t('main' ,'указывает тип возвращаемой статистики, может принимать одно из следующих значений:') ?> day, week, month;<br>
                    <strong class="text-warning">forJavaScript</strong> - <?= Yii::t('main' ,'возвращает данные в виде JavaScript переменой (см. пример в конце).') ?>
                </p>
                <hr>
                <div style="overflow-y: auto">
                <table class="table table-sm stylish-table">
                    <thead>
                    <tr>
                        <td><?= Yii::t('main' ,'Имя') ?></td>
                        <td><?= Yii::t('main' ,'Тип данных') ?></td>
                        <td><?= Yii::t('main' ,'Пример') ?></td>
                        <td><?= Yii::t('main' ,'Описание') ?></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="strong">serverId</td>
                        <td class="italic">integer</td>
                        <td>14370</td>
                        <td><?= Yii::t('main' ,'Идентификатор (ID) сервера') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">per</td>
                        <td class="italic">string</td>
                        <td>day</td>
                        <td><?= Yii::t('main' ,'Период возвращаемой статистики') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">averageOnline</td>
                        <td class="italic">integer</td>
                        <td>527</td>
                        <td><?= Yii::t('main' ,'Средний онлайн за выбранный период') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">maximumOnline</td>
                        <td class="italic">integer</td>
                        <td>1000</td>
                        <td><?= Yii::t('main' ,'Максимальный онлайн за выбранный период') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">list</td>
                        <td class="italic">array</td>
                        <td></td>
                        <td><?= Yii::t('main' ,'Статистика') ?></td>
                    </tr>
                    </tbody>
                </table>
                </div>
                <h5><?= Yii::t('main' ,'Возвращаемые данные') ?>:</h5>
                <br>
<?= Yii::t('main' ,'Возвращаемые данные массива') ?> <span class="strong">list</span> <?= Yii::t('main' ,'при') ?> <code>&<span class="text-warning">per</span>=day</code>:
                <div style="overflow-y: auto">
                <table class="table table-sm stylish-table">
                    <thead>
                    <tr>
                        <td><?= Yii::t('main' ,'Имя') ?></td>
                        <td><?= Yii::t('main' ,'Тип данных') ?></td>
                        <td><?= Yii::t('main' ,'Пример') ?></td>
                        <td><?= Yii::t('main' ,'Описание') ?></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="strong">id</td>
                        <td class="italic">integer</td>
                        <td>2909512</td>
                        <td><?= Yii::t('main' ,'Идентификатор (ID) статистики') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">players</td>
                        <td class="italic">integer</td>
                        <td>485</td>
                        <td><?= Yii::t('main' ,'Количество игроков') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">createdAt</td>
                        <td class="italic">string</td>
                        <td>2018-09-17 21:55:09</td>
                        <td><?= Yii::t('main' ,'Дата создания статистики') ?></td>
                    </tr>
                    </tbody>
                </table>
                </div>
                <br>
<?= Yii::t('main' ,'Возвращаемые данные массива') ?> <span class="strong">list</span> <?= Yii::t('main' ,'при') ?> <code>&<span class="text-warning">per</span>=week</code> / <code>&<span class="text-warning">per</span>=month</code>:
                <div style="overflow-y: auto">
                <table class="table table-sm stylish-table">
                    <thead>
                    <tr>
                        <td><?= Yii::t('main' ,'Имя') ?></td>
                        <td><?= Yii::t('main' ,'Тип данных') ?></td>
                        <td><?= Yii::t('main' ,'Пример') ?></td>
                        <td><?= Yii::t('main' ,'Описание') ?></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="strong">id</td>
                        <td class="italic">integer</td>
                        <td>2909512</td>
                        <td><?= Yii::t('main' ,'Идентификатор (ID) статистики') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">averageOnline</td>
                        <td class="italic">integer</td>
                        <td>520</td>
                        <td><?= Yii::t('main' ,'Средний онлайн, в день') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">maximumOnline</td>
                        <td class="italic">integer</td>
                        <td>829</td>
                        <td><?= Yii::t('main' ,'Максимальный онлайн, в день') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">createdAt</td>
                        <td class="italic">string</td>
                        <td>2018-09-17 21:55:09</td>
                        <td><?= Yii::t('main' ,'Дата создания статистики') ?></td>
                    </tr>
                    </tbody>
                </table>
                </div>
                <hr>
                <h5><?= Yii::t('main' ,'Пример возвращаемых данных') ?>:</h5>
                <pre><code class="javascript">// <?= Yii::t('main' ,'Запрос') ?>: https://servers.fun/api/statistics/3242?per=day
{
    "serverId": 3242,
    "per": "day",
    "averageOnline": 178,
    "maximumOnline": 388,
    "list": [
        // ...................
        {"id": 3986987, "players": 167, "createdAt": "2018-09-21 10:00:32"},
        {"id": 3983195, "players": 155, "createdAt": "2018-09-21 09:45:32"},
        {"id": 3979444, "players": 153, "createdAt": "2018-09-21 09:30:32"},
        {"id": 3975763, "players": 140, "createdAt": "2018-09-21 09:15:34"},
        // ...................
    ]
}</code></pre>
                <hr>
                <h5><?= Yii::t('main' ,'Пример возвращаемых данных') ?> #2:</h5>
                <pre><code class="javascript">// <?= Yii::t('main' ,'Запрос') ?>: https://servers.fun/api/statistics/3242?per=month&forJavaScript=true
var statistic = JSON.parse('{
    "serverId": 3242,
    "per": "month",
    "averageOnline": 195,
    "maximumOnline": 488,
    "list": [
        // ...................
        {"id": 53419, "averageOnline": 178, "maximumOnline": 388, "createdAt": "2018-09-20 13:00:30"},
        {"id": 48611, "averageOnline": 147, "maximumOnline": 350, "createdAt": "2018-09-19 13:00:33"},
        {"id": 47259, "averageOnline": 152, "maximumOnline": 276, "createdAt": "2018-09-18 13:00:32"},
        {"id": 42295, "averageOnline": 240, "maximumOnline": 444, "createdAt": "2018-09-17 12:15:14"},
        // ...................
    ]
}');</code></pre>
            </div>
        </div>
        <div class="card" id="4">
            <div class="card-body">
                <h3 class="card-title"><?= Yii::t('main' ,'Информация о игроках') ?></h3>
                <p><?= Yii::t('main' ,'Получение информации о игроках') ?>:</p>
                <pre><code class="html">https://servers.fun/api/players/<span
                                class="text-primary">&lt;IDENTIFIER&gt;</span>?<span class="text-warning">type</span>=(online/top)&<span
                                class="text-warning">forJavaScript</span>=true
<hr class="m-b-0 m-t-10">
&lt;!-- <?= Yii::t('main' ,'Примеры использования') ?>: --&gt;
https://servers.fun/api/players/<span class="text-primary">14370</span>?<span class="text-warning">type</span>=online
https://servers.fun/api/players/<span class="text-primary">95.213.255.83:7771</span>?<span class="text-warning">type</span>=online
https://servers.fun/api/players/<span class="text-primary">14370</span>?<span class="text-warning">type</span>=top&<span class="text-warning">forJavaScript</span>=true</code></pre>
                <p></p>
                <p class="font-14"><strong class="text-primary">&lt;IDENTIFIER&gt;</strong> - <?= Yii::t('main' ,'идентификатор сервера, которым может выступать') ?> <span class="text-info"><?= Yii::t('main' ,'ID сервера') ?></span> <?= Yii::t('main' ,'в мониторинге или же его') ?> <span
                            class="text-info"><?= Yii::t('main' ,'адрес') ?></span> (IP:PORT);<br>
                    <strong class="text-warning">type</strong> - <?= Yii::t('main' ,'указывает тип возвращаемой информации, может принимать одно из следующих значений: online (список игроков онлайн), top (топ-100 игроков по количеству отыгранного времени);') ?><br>
                    <strong class="text-warning">forJavaScript</strong> - <?= Yii::t('main' ,'возвращает данные в виде JavaScript переменой (см. пример в конце).') ?>
                </p>
                <hr>
                <h5><?= Yii::t('main' ,'Возвращаемые данные') ?>:</h5>
                <div style="overflow-y: auto">
                <table class="table table-sm stylish-table">
                    <thead>
                    <tr>
                        <td><?= Yii::t('main' ,'Имя') ?></td>
                        <td><?= Yii::t('main' ,'Тип данных') ?></td>
                        <td><?= Yii::t('main' ,'Пример') ?></td>
                        <td><?= Yii::t('main' ,'Описание') ?></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="strong">serverId</td>
                        <td class="italic">integer</td>
                        <td>14370</td>
                        <td><?= Yii::t('main' ,'Идентификатор (ID) сервера') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">type</td>
                        <td class="italic">string</td>
                        <td>online</td>
                        <td><?= Yii::t('main' ,'Тип информации о игроках') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">list</td>
                        <td class="italic">array</td>
                        <td></td>
                        <td><?= Yii::t('main' ,'Список игроков') ?></td>
                    </tr>
                    </tbody>
                </table>
                </div>
                <br>
<?= Yii::t('main' ,'Возвращаемые данные массива') ?> <span class="strong">list</span> <?= Yii::t('main' ,'при') ?> <code>&<span class="text-warning">type</span>=online</code> / <code>&<span class="text-warning">type</span>=top</code>:
                <div style="overflow-y: auto">
                <table class="table table-sm stylish-table">
                    <thead>
                    <tr>
                        <td><?= Yii::t('main' ,'Имя') ?></td>
                        <td><?= Yii::t('main' ,'Тип данных') ?></td>
                        <td><?= Yii::t('main' ,'Пример') ?></td>
                        <td><?= Yii::t('main' ,'Описание') ?></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="strong">id</td>
                        <td class="italic">integer</td>
                        <td>58282</td>
                        <td><?= Yii::t('main' ,'Идентификатор (ID) игрока') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">nickname</td>
                        <td class="italic">string</td>
                        <td>brebvix</td>
                        <td><?= Yii::t('main' ,'Никнейм игрока') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">playedMinutes</td>
                        <td class="italic">string</td>
                        <td>120</td>
                        <td><?= Yii::t('main' ,'Количество отыгранных минут на сервере') ?></td>
                    </tr>
                    <tr>
                        <td class="strong">lastActivity</td>
                        <td class="italic">string</td>
                        <td>2018-09-17 12:15:14</td>
                        <td><?= Yii::t('main' ,'Дата последнего посещения сервера') ?></td>
                    </tr>
                    </tbody>
                </table>
                </div>
                <hr>
                <h5><?= Yii::t('main' ,'Пример возвращаемых данных') ?>:</h5>
                <pre><code class="javascript">// <?= Yii::t('main' ,'Запрос') ?>: https://servers.fun/api/players/16896?type=online
{
    "serverId": 16896,
    "type": "online",
    "list": [
        // ...................
        {"id": "Harry_Odebrecht", "nickname": "Harry_Odebrecht", "playedMinutes": 30, "lastActivity": "2018-09-21 00:00:27"},
        {"id": "Felipe_Hobbs", "nickname": "Felipe_Hobbs", "playedMinutes": 15, "lastActivity": "2018-09-21 00:00:25"},
        {"id": "Terry_Harper", "nickname": "Terry_Harper", "playedMinutes": 15, "lastActivity": "2018-09-21 00:00:21"},
        {"id": "Kenny_Franchetti", "nickname": "Kenny_Franchetti", "playedMinutes": 15, "lastActivity": "2018-09-21 00:00:20"},
        // ...................
    ]
}</code></pre>
                <hr>
                <h5><?= Yii::t('main' ,'Пример возвращаемых данных') ?> #2:</h5>
                <pre><code class="javascript">// <?= Yii::t('main' ,'Запрос') ?>: https://servers.fun/api/players/16896?type=top&forJavaScript=true
var players = JSON.parse('{
    "serverId": 16896,
    "type": "top",
    "list": [
        // ...................
        {"id": "Harry_Odebrecht", "nickname": "Rubens_Junior", "playedMinutes": 165, "lastActivity": "2018-09-21 00:00:27"},
        {"id": "Felipe_Hobbs", "nickname": "Griffley_Wakabayashi", "playedMinutes": 140, "lastActivity": "2018-09-21 00:00:27"},
        {"id": "Terry_Harper", "nickname": "Lukaku_Hobbs", "playedMinutes": 90, "lastActivity": "2018-09-21 00:00:27"},
        {"id": "Kenny_Franchetti", "nickname": "Calvin_Galaxy", "playedMinutes": 75, "lastActivity": "2018-09-21 00:00:27"},
        // ...................
    ]
}');</code></pre>
            </div>
        </div>
        <div class="card" id="5">
            <div class="card-body">
                <h3 class="card-title"><?= Yii::t('main' ,'Примеры использования') ?> API</h3>
<?= Yii::t('main' ,'Для лучшего понимания работы API Вы можете использовать любой из перечисленных примеров:') ?>
                <ul>
                    <li><a href="https://github.com/brebvix/servers.fun_api_php" target="_blank">https://github.com/brebvix/servers.fun_api_php</a> - <?= Yii::t('main' ,'пример использования всех доступных в API функций с помощью') ?> <strong>PHP</strong>.</li>
                </ul>
            </div>
        </div>
    </div>
</div>