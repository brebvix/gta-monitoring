<?php

use yii\helpers\Url;
use common\models\Comments;
use frontend\widgets\CommentsWidget;
use yii\widgets\ActiveForm;
use common\models\AchievementsList;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

$gameTitle = $server->game->title;

if ($gameTitle == 'RAGE Multiplayer') {
    $url = 'rage-multiplayer';
} else {
    $url = strtolower($gameTitle);
}

$this->title = $server->title . ' / ' . Yii::t('main', '{game} сервер', ['game' => $gameTitle]);
Yii::$app->params['breadcrumbs'][] = [
    'label' => $gameTitle . ' ' . Yii::t('main', 'сервера'),
    'url' => [
        '/servers/' . $url
    ]
]; //Yii::t('main', 'Сервера');
Yii::$app->params['breadcrumbs'][] = substr($server->title, 0, 36);

$keywords = str_replace(' ', ', ', $server->title);

Yii::$app->params['description'] = Yii::t('main', $gameTitle . ' сервер') . ' ' . $server->title . ' (' . Yii::t('main', 'Адрес') . ': ' . $server->ip . ':' . $server->port . '): ' . Yii::t('main', 'отзывы, статистика, WEB-модули, платные услуги.');

if ($server->language == 'en') {
    $server->language = 'us';
}

$this->registerJsFile('/template_assets/plugins/echarts/echarts-all.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/page_server.js', ['depends' => 'yii\web\JqueryAsset']);

$achievements = $server->achievements;
?>
    <div class="row" itemscope itemtype="http://schema.org/Product">

        <div class="col-lg-4 col-xlg-3 col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="pull-left">
                        <?php if (!empty($achievements)): ?>
                            <?php foreach ($achievements AS $achievement): ?>
                                <span style="font-size:18px;" data-toggle="tooltip"
                                      title="<?= Yii::t('main', 'Достижение') ?>: <?= Yii::t('main', $achievement->achievement->description) ?>"
                                      class="badge badge-<?= $achievement->achievement->type_positive == AchievementsList::TYPE_POSITIVE_YES ? 'success' : 'danger' ?>">
                                    <?= $achievement->achievement->icon ?>
                                </span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="pull-right">
                        <?php if ($server->status == \common\models\Servers::STATUS_ACTIVE && $server->offline_count == 0): ?>
                            <span class="badge badge-primary"><?= Yii::t('main', 'Работает') ?></span>
                        <?php elseif ($server->status == \common\models\Servers::STATUS_ACTIVE && $server->offline_count > 0): ?>
                            <span class="badge badge-warning"><?= Yii::t('main', 'Недоступен') ?>
                                <?= $server->offline_count * 15 ?> <?= Yii::t('main', 'минут') ?></span>
                        <?php else: ?>
                            <span class="badge badge-danger"><?= Yii::t('main', 'Выключен более 3-х часов') ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="text-center">
                        <div id="gauge-chart" style="width:100%; height:250px;"></div>
                        <div class="row text-center justify-content-md-center m-b-0 m-t-0" style="font-size: 24px;">
                            <div class="col-6"><a href="<?= Url::to(['/rating/down', 'server_id' => $server->id]) ?>"
                                                  class="link text-danger"><span class="font-medium"><i
                                                class="mdi mdi-thumb-down"></i></span></a></div>
                            <div class="col-6"><a href="<?= Url::to(['/rating/up', 'server_id' => $server->id]) ?>"
                                                  class="link text-success"><span class="font-medium"><i
                                                class="mdi mdi-thumb-up"></i></span></a></div>
                        </div>
                        <h1 class="card-title m-t-10" style="font-size:18px;line-height: 22px;">
                            <?= $server->game_id == 7 ? '<i class="flag-icon flag-icon-' . $server->language . '"></i>' : '' ?>
                            <span itemprop="name"><?= $server->title ?></span></h1>
                        <h6 class="card-subtitle"><a
                                    href="<?= $server->connectHref() ?>"><?= $server->ip . ':' . $server->port ?></a>
                        </h6>
                    </div>
                    <div class="text-center">
                        <a href="https://t.me/ServersFun_bot?start=<?= $server->id ?>" target="_blank"
                           data-toggle="tooltip" title="Если вы уже добавили бота - просто введите /addserver <?= $server->id ?>"
                           class="btn btn-primary waves-effect waves-light"><span class="btn-label"><i class="mdi mdi-telegram"></i></span> Telegram bot</a>
                    </div>
                    <?php if (!Yii::$app->user->isGuest):
                        $favoriteExist = \common\models\UserFavoriteServers::exist($server->id, Yii::$app->user->id);
                        ?>
                        <br>
                        <div class="text-center">
                            <a href="<?= Url::to(['/server/favorite', 'id' => $server->id]) ?>"
                               class="btn btn-<?= $favoriteExist ? 'success' : 'primary' ?> text-light">
                                <?= Yii::t('main', $favoriteExist ? 'Убрать из избранного' : 'Добавить в избранное') ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <div>
                    <hr>
                </div>
                <div class="card-body">
                    <small class="text-muted"><?= Yii::t('main', 'Игра') ?></small>
                    <h6><span itemprop="brand"><?= $server->game->title ?></span></h6>
                    <?php if (!empty($server->maxplayers)): ?>
                        <small class="text-muted p-t-30 db"><?= Yii::t('main', 'Игроки онлайн') ?></small>
                        <h6><?= $server->players ?> / <?= $server->maxplayers ?></h6>
                    <?php endif; ?>
                    <?php if (!empty($server->site)): ?>
                        <small class="text-muted p-t-30 db"><?= Yii::t('main', 'Сайт') ?></small>
                        <h6><a href="http://<?= $server->site ?>" target="_blank"> <?= $server->site ?></a></h6>
                    <?php endif; ?>
                    <?php if (!empty($server->language)): ?>
                        <small class="text-muted p-t-30 db"><?= Yii::t('main', 'Язык') ?></small>
                        <h6><?= $server->language ?></h6>
                    <?php endif; ?>
                    <?php if (!empty($server->version)): ?>
                        <small class="text-muted p-t-30 db"><?= Yii::t('main', 'Версия') ?></small>
                        <h6><?= $server->version ?></h6>
                    <?php endif; ?>
                    <?php if (!empty($server->rating)): ?>
                        <small class="text-muted p-t-30 db"><?= Yii::t('main', 'Рейтинг сервера') ?></small>
                        <h6 itemprop="aggregateRating"
                            itemscope itemtype="http://schema.org/AggregateRating">
                            <span itemprop="ratingValue"><?= number_format($server->rating, 2, '.', ' ') ?></span> / 10
                            <meta itemprop="worstRating" content="0"/>
                            <meta itemprop="bestRating" content="10"/>
                            <meta itemprop="ratingCount"
                                  content="<?= round($server->rating_up + $server->rating_down) ?>"/>
                        </h6>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-xlg-9 col-md-7">
            <div class="card">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs profile-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                            <i class="mdi mdi-comment-text-outline"></i>
                            <span class="d-none d-xl-inline-block"><?= Yii::t('main', 'Отзывы') ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" id="nav-statistic" href="#statistic" role="tab">
                            <i class="mdi mdi-chart-line"></i>
                            <span class="d-none d-xl-inline-block"><?= Yii::t('main', 'Статистика') ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" id="nav-players" href="#players" role="tab">
                            <i class="mdi mdi-gamepad-variant"></i>
                            <span class="d-none d-xl-inline-block"><?= Yii::t('main', 'Игроки') ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#vip-1" role="tab">
                            <i class="mdi mdi-star-circle"></i>
                            <span class="d-none d-xl-inline-block"><?= Yii::t('main', 'Закрепление в ТОП') ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#vip-2" role="tab">
                            <i class="mdi mdi-star"></i>
                            <span class="d-none d-xl-inline-block"><?= Yii::t('main', 'Выделение') ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#web" role="tab">
                            <i class="mdi mdi-image-filter-frames"></i>
                            <span class="d-none d-xl-inline-block"><?= Yii::t('main', 'WEB-Модули') ?></span>
                        </a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="home" role="tabpanel">
                        <div class="card-body">
                            <div class="text-right">
                                <a href="<?= Url::to(['/server/add-description', 'id' => $server->id]) ?>"
                                   class="btn btn-success text-light"><?= Yii::t('main', 'Добавить описание') ?></a>
                            </div>
                            <span itemprop="description"
                                  class="<?= empty($server->description) ? 'd-none' : '' ?>"><?= !empty($server->description) ? \kartik\markdown\Markdown::convert($server->description) : 'Server ' . $server->title ?></span>
                            <hr>
                            <?php
                            $widgetResult = CommentsWidget::widget(['id' => $server->id, 'type' => Comments::TYPE_SERVER]);
                            if (is_string($widgetResult)) {
                                echo $widgetResult;
                            }
                            ?>

                        </div>
                    </div>
                    <div class="tab-pane" id="statistic" role="tabpanel">
                        <div class="card-body">
                            <div id="main" style="width:100%; height:400px;"></div>
                            <hr>
                            <div id="main2" style="width:100%; height: 400px;"></div>
                            <hr>
                            <div id="main3" style="width:100%; height: 400px;"></div>
                        </div>
                    </div>
                    <div class="tab-pane" id="players" role="tabpanel">
                        <div class="card-body" style="overflow-x:auto;">

                            <?php
                            Pjax::begin();
                            $players = $server->getPlayers()
                                ->orderBy(['minutes' => SORT_DESC])
                                ->with('player');

                            $provider = new \yii\data\ActiveDataProvider([
                                'query' => $players,
                                'sort' => false,
                                'totalCount' => 100,
                                'pagination' => [
                                    'pageSize' => 100,
                                ],
                            ]);

                            $this->registerJs("$(document).ready(function() {
                                    $('.page-item').each(function() {
                                        $(this).find('a').addClass('page-link');
                                        $(this).find('span').addClass('page-link');
                                    });
                                });");
                            ?>

                            <?= GridView::widget([
                                'dataProvider' => $provider,
                                'tableOptions' => [
                                    'class' => 'table table-clickable table-hover stylish-table'
                                ],
                                //'filterModel' => $searchModel,
                                'summary' => false,
                                'pager' => [
                                    'activePageCssClass' => 'active',
                                    'firstPageCssClass' => 'page-item',
                                    'lastPageCssClass' => 'page-item',
                                    'nextPageCssClass' => 'page-item',
                                    'pageCssClass' => 'page-item',
                                    'prevPageCssClass' => 'page-item',
                                    'options' => [
                                        'class' => 'pagination pull-right',
                                    ],
                                ],
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],

                                    [
                                        'attribute' => 'nickname',
                                        'label' => Yii::t('main', 'Никнейм'),
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            if (is_object($model->player)) {
                                                return Html::a(
                                                    $model->player->nickname,
                                                    [
                                                        '/players/view',
                                                        'id' => $model->player_id,
                                                        'nickname_eng' => $model->player->nickname_eng
                                                    ],
                                                    [
                                                        'data-pjax' => 0,
                                                    ]);
                                            } else {
                                                return '';
                                            }
                                        },
                                    ],
                                    [
                                        'attribute' => 'minutes',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return Yii::$app->formatter->asDuration($model->minutes * 60);
                                        }
                                    ],
                                    [
                                        'attribute' => 'date',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return '<span data-toggle="tooltip" title="' . $model->date . '">' . Yii::$app->formatter->asRelativeTime($model->date) . '</span>';
                                        }
                                    ],
                                ],
                            ]); ?>
                            <?php Pjax::end(); ?>
                        </div>
                    </div>
                    <div class="tab-pane" id="vip-1" role="tabpanel">
                        <div class="card-body">
                            <div class="card">

                                <div class="card-body">
                                    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-material']]); ?>
                                    <?= $form->field($buyTopModel, 'days')->textInput() ?>
                                    <br>
                                    <div class="text-center">
                                        <button type="submit"
                                                class="btn btn-primary m-b-20 p-10 btn-block waves-effect waves-light">
                                            <?= Yii::t('main', 'Купить поднятие в ТОП за') ?> <span
                                                    id="topResultAmount">0</span><i class="mdi mdi-currency-rub"></i>
                                        </button>
                                    </div>
                                    <?php ActiveForm::end(); ?>
                                    <h3 class="card-title"><?= Yii::t('main', 'Закрепление в ТОП') ?></h3>
                                    <p class="card-text"><?= Yii::t('main', 'Если Ваш сервер еще не успел заработать много положительных оценок - наверняка он далеко от первых позиций. И у вас есть возможность это исправить!') ?></p>
                                    <h4 class="card-title"><?= Yii::t('main', 'Как это работает?') ?></h4>
                                    <p class="card-text"><?= Yii::t('main', 'После заказа данной услуги сервер автоматически поднимается на первые позиции рейтинга. Обратите внимание! Несмотря на то, что сервер имеет преимущество перед серверами без закрепления в ТОПе, это не гарантирует, что Ваш сервер всегда будет на первом месте. Даже среди закрепленных серверов происходит сортировка по рейтингу.') ?></p>
                                    <h4 class="card-title"><?= Yii::t('main', 'Стоимость закрепления сервера?') ?></h4>
                                    <p class="card-text"><?= Yii::t('main', 'Актуальная стоимость закрепления сервера составляет <u>10р. в день</u>.') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="vip-2" role="tabpanel">
                        <div class="card-body">
                            <div class="card">
                                <div class="card-body">
                                    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-material']]); ?>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h3 class="text-center text-muted"><?= Yii::t('main', 'Цвет фона') ?></h3>
                                            <?= $form->field($buyBackgroundModel, 'background')->dropDownList([
                                                'bg-dark' => Yii::t('main', 'Черный'),
                                                'bg-danger' => Yii::t('main', 'Красный'),
                                                'bg-warning' => Yii::t('main', 'Желтый'),
                                                'bg-primary' => Yii::t('main', 'Фиолетовый'),
                                                'bg-info' => Yii::t('main', 'Голубой'),
                                                'bg-success' => Yii::t('main', 'Зеленый'),
                                                'bg-secondary' => Yii::t('main', 'Серый'),
                                            ], ['size' => 7, 'class' => 'form-control set_background'])->label(false) ?>
                                        </div>
                                        <div class="col-md-9" style="overflow-x:auto;">
                                            <h3 class="text-center text-muted"><?= Yii::t('main', 'Пример') ?></h3>

                                            <table class="table stylish-table">
                                                <thead>
                                                <tr>
                                                    <td><?= Yii::t('main', 'Рейтинг') ?></td>
                                                    <td><?= Yii::t('main', 'Сервер') ?></td>
                                                    <td><?= Yii::t('main', 'Игроки') ?></td>
                                                    <td></td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="m-b-0" id="table-result">
                                                    <td>
                                                        <h2 class="font-light text-color text-primary m-b-0"><span
                                                                    style="white-space: pre;"><?= number_format($server->rating, 2, '.', '') ?>
                                                                <sup class="text-muted text-color"> / 10</sup></span>
                                                        </h2>
                                                    </td>
                                                    <td>
                                                        <h5 class="text-color"><?= $server->title ?></h5>
                                                        <small class="text-muted text-color"><a
                                                                    class="text-color text-muted"
                                                                    href="<?= $server->connectHref() ?>"
                                                                    target="_blank"><?= $server->ip ?>
                                                                :<?= $server->port ?></a></small>
                                                    </td>
                                                    <td>
                                                        <h2 class="font-light text-color m-b-0"><span
                                                                    style="white-space: pre;"><?= $server->players ?>
                                                                <span
                                                                        class="text-color text-muted">/ <?= $server->maxplayers ?></span></span>
                                                        </h2>
                                                    </td>
                                                    <td>
                                                        <a href="#"
                                                           data-pjax="0"
                                                           class="btn btn-primary btn-circle m-b-0 p-10 btn-block waves-effect waves-light">
                                                            <i class="mdi mdi-link"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <?= $form->field($buyBackgroundModel, 'days')->textInput() ?>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="text-center">
                                        <button type="submit"
                                                class="btn btn-primary m-b-20 p-10 btn-block waves-effect waves-light">
                                            <?= Yii::t('main', 'Купить "Выделение цветом" за') ?> <span
                                                    id="resultAmount">0</span><i class="mdi mdi-currency-rub"></i>
                                        </button>
                                    </div>
                                    <?php ActiveForm::end(); ?>
                                    <hr>
                                    <h3 class="card-title"><?= Yii::t('main', 'Выделение сервера цветом') ?></h3>
                                    <p class="card-text"><?= Yii::t('main', 'Выделение цветом положительно влияет на привлечение новых игроков, благодаря своему броскому виду.') ?></p>
                                    <h4 class="card-title"><?= Yii::t('main', 'Как заказать выделение цветом?') ?></h4>
                                    <p class="card-text"><?= Yii::t('main', 'Для заказа выделения цветом Вам достаточно зайти на страничку интересующего Вас сервера, и нажать кнопку "Купить выделение цветом". Во всплываещем окне Вам достаточно выбрать цвет, которым Вы хотите выделить сервер, а так же выбрать количество дней.') ?></p>
                                    <h4 class="card-title"><?= Yii::t('main', 'Стоимость выделения цветом?') ?></h4>
                                    <p class="card-text"><?= Yii::t('main', 'Актуальная стоимость выделения цветом составляет <u>5р. в день</u>.') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="web" role="tabpanel">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <iframe src="https://servers.fun/api/web-one?server_id=<?= $server->id ?>"
                                            height="460" style="border: 0px; width: 100%;"></iframe>
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-5">
                                    <iframe src="https://servers.fun/api/web-one-dark?server_id=<?= $server->id ?>"
                                            height="460" style="border: 0px; width: 100%;"></iframe>
                                </div>
                            </div>
                            <br>
                            <div class="row text-center">
                                <div class="col-md-6">
                                    <code>
                                        &lt;iframe
                                        src="https://servers.fun/api/web-one?server_id=<?= $server->id ?>" height="460"
                                        style="border: 0px; width: 100%;"&gt;&lt;/iframe&gt;
                                    </code>
                                </div>
                                <div class="col-md-6">
                                    <code>
                                        &lt;iframe
                                        src="https://servers.fun/api/web-one-dark?server_id=<?= $server->id ?>"
                                        height="460" style="border: 0px; width: 100%;"&gt;&lt;/iframe&gt;
                                    </code>
                                </div>
                            </div>
                            <hr>
                            <iframe src="https://servers.fun/api/web-two?server_id=<?= $server->id ?>" height="200"
                                    style="border: 0px; width: 100%;"></iframe>
                            <div class="text-center">
                                <code>
                                    &lt;iframe src="https://servers.fun/api/web-two?server_id=<?= $server->id ?>"
                                    height="200" style="border: 0px; width: 100%;"&gt;&lt;/iframe&gt;
                                </code>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-none" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
            <div class="event-price" itemprop="price" content="0">$0</div>
            <meta itemprop="priceCurrency" content="USD"/>
            <a itemprop="url" href="<?= Yii::$app->request->url ?>"><?= $server->title ?></a>
        </div>
    </div>
<?php
$rating = '';
$date = '';

foreach ($ratingStatistic AS $statistic) {
    $rating .= number_format($statistic->rating, 2, '.', '') . ', ';
    $date .= '"' . date('d.m.Y H:i:s', strtotime($statistic->date)) . '",';
}

$this->registerJs("var dom = document.getElementById(\"main3\");
var mytempChart3 = echarts.init(dom);
var app = {};
option = null;
option = {
   
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        data:['" . Yii::t('main', 'Рейтинг') . "']
    },
    toolbox: {
        show : true,
        feature : {
            magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    color: [\"#26c6da\"],
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
            data : [" . substr($date, 0, -1) . "]
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
                formatter: '{value}'
            }
        }
    ],

    series : [
        {
            name:'" . Yii::t('main', 'Рейтинг') . "',
            type:'line',
            color:['#000'],
            data:[" . substr($rating, 0, -1) . "],
            itemStyle: {
                normal: {
                    lineStyle: {
                        shadowColor : 'rgba(0,0,0,0.3)',
                        shadowBlur: 10,
                        shadowOffsetX: 8,
                        shadowOffsetY: 8 
                    }
                }
            }
        }
    ]
};

if (option && typeof option === \"object\") {
    mytempChart3.setOption(option, true), $(function() {
            function resize() {
                setTimeout(function() {
                    mytempChart3.resize()
                }, 100)
            }
            
            $('#nav-statistic').on('click',function() {resize();});
            $(window).on(\"resize\", resize), $(\".sidebartoggler\").on(\"click\", resize)
        });
}", 3);
// ___________________________________________
$players = '';
$date = '';

foreach ($dayliStatistic AS $statistic) {
    $players .= $statistic->players . ', ';
    $date .= '"' . date('d.m.Y H:i:s', strtotime($statistic->date)) . '",';
}

$this->registerJs("var dom = document.getElementById(\"main2\");
var mytempChart2 = echarts.init(dom);
var app = {};
option = null;
option = {
   
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        data:['" . Yii::t('main', 'Онлайн') . "']
    },
    toolbox: {
        show : true,
        feature : {
            magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    color: [\"#26c6da\"],
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
            data : [" . substr($date, 0, -1) . "]
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
                formatter: '{value}'
            }
        }
    ],

    series : [
        {
            name:'" . Yii::t('main', 'Онлайн') . "',
            type:'line',
            color:['#000'],
            data:[" . substr($players, 0, -1) . "],
            smooth: true,
            itemStyle: {
                normal: {
                    lineStyle: {
                        shadowColor : 'rgba(0,0,0,0.3)',
                        shadowBlur: 10,
                        shadowOffsetX: 8,
                        shadowOffsetY: 8 
                    }
                }
            }
        }
    ]
};

if (option && typeof option === \"object\") {
    mytempChart2.setOption(option, true), $(function() {
            function resize() {
                setTimeout(function() {
                    mytempChart2.resize()
                }, 100)
            }
            
            $('#nav-statistic').on('click',function() {resize();});
            $(window).on(\"resize\", resize), $(\".sidebartoggler\").on(\"click\", resize)
        });
}", 3);

$averageOnline = '';
$maximumOnline = '';
$date = '';

foreach ($statistics AS $statistic) {
    $averageOnline .= $statistic->average_online . ', ';
    $maximumOnline .= $statistic->maximum_online . ', ';
    $date .= '"' . date('d.m.Y', strtotime($statistic->date)) . '",';
}

$this->registerJs("var dom = document.getElementById(\"main\");
var mytempChart = echarts.init(dom);
var app = {};
option = null;
option = {
   
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        data:['" . Yii::t('main', 'Средний онлайн') . "','" . Yii::t('main', 'Максимальный онлайн') . "']
    },
    toolbox: {
        show : true,
        feature : {
            magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    color: [\"#26c6da\", \"#fc4b6c\"],
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
            data : [" . substr($date, 0, -1) . "]
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
                formatter: '{value}'
            }
        }
    ],

    series : [
        {
            name:'" . Yii::t('main', 'Максимальный онлайн') . "',
            type:'line',
            color:['#000'],
            smooth: true,
            data:[" . substr($maximumOnline, 0, -1) . "],
            itemStyle: {
                normal: {
                    lineStyle: {
                        shadowColor : 'rgba(0,0,0,0.3)',
                        shadowBlur: 10,
                        shadowOffsetX: 8,
                        shadowOffsetY: 8 
                    }
                }
            }
        },
        {
            name:'" . Yii::t('main', 'Средний онлайн') . "',
            type:'line',
            data:[" . substr($averageOnline, 0, -1) . "],
            itemStyle: {
                normal: {
                    lineStyle: {
                        shadowColor : 'rgba(0,0,0,0.3)',
                        shadowBlur: 10,
                        shadowOffsetX: 8,
                        shadowOffsetY: 8 
                    }
                }
            }
        }
    ]
};

if (option && typeof option === \"object\") {
    mytempChart.setOption(option, true), $(function() {
            function resize() {
                setTimeout(function() {
                    mytempChart.resize()
                }, 100)
            }
            
            $('#nav-statistic').on('click',function() {resize();});
            $(window).on(\"resize\", resize), $(\".sidebartoggler\").on(\"click\", resize)
        });
}", 3);

$this->registerJs("var gaugeChart = echarts.init(document.getElementById('gauge-chart'));

option = {
    toolbox: {
        show : false,
        feature : {
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    series : [
        {
            name:'" . Yii::t('main', 'Рейтинг') . "',
            type:'gauge',
            min: 0,
            max: 10,

            data:[{value: " . number_format($server->rating, 2, '.', ' ') . ", name: '" . Yii::t('main', 'Рейтинг') . "'}],
                        axisLine: {            // 坐标轴线
                lineStyle: {       // 属性lineStyle控制线条样式
                    width: 10,
                                        color: [[0.1, '#DF0101'],[0.2, '#DF3A01'],[0.3, '#DF7401'],[0.4, '#DBA901'],[0.5, '#D7DF01'],
                    [0.6, '#A5DF00'],[0.7, '#74DF00'],[0.8, '#01DF74'],[0.9, '#01DFA5'],[1, '#01DFD7']],
                }
            },
            axisTick: {            // 坐标轴小标记
                length: 15,        // 属性length控制线长
                lineStyle: {       // 属性lineStyle控制线条样式
                    color: 'auto'
                }
            },
            splitLine: {           // 分隔线
                length: 20,         // 属性length控制线长
                lineStyle: {       // 属性lineStyle（详见lineStyle）控制线条样式
                    color: 'auto'
                }
            },
            axisLabel: {
                backgroundColor: 'auto',
                borderRadius: 2,
                color: '#eee',
                padding: 3,
                textShadowBlur: 2,
                textShadowOffsetX: 1,
                textShadowOffsetY: 1,
                textShadowColor: '#222'
            },
            title : {
                // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                fontWeight: 'bolder',
                fontSize: 20,
                fontStyle: 'italic'
            }
        }
    ]
};                      

// use configuration item and data specified to show chart
gaugeChart.setOption(option, true), $(function() {
            function resize() {
                setTimeout(function() {
                    gaugeChart.resize()
                }, 100)
            }
            $(window).on(\"resize\", resize), $(\".sidebartoggler\").on(\"click\", resize)
        });", 3);
?>