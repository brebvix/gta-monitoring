<?php

use yii\helpers\Url;
use yii\widgets\ListView;

$this->registerJsFile('/template_assets/plugins/horizontal-timeline/js/horizontal-timeline.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerCssFile('/template_assets/plugins/horizontal-timeline/css/horizontal-timeline.css');

$this->title = Yii::t('main', 'Заказ игрового хостинга серверов');
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Игровой хостинг'), 'url' => Url::to(['/hosting'])];
Yii::$app->params['breadcrumbs'][] = Yii::t('main', 'Заказ');
Yii::$app->params['breadcrumbs'][] = Yii::t('main', 'Шаг') . ' ' . 1;
$availableColors = ['bg-primary', 'bg-success', 'bg-danger', 'bg-info', 'bg-warning'];
Yii::$app->params['description'] = Yii::t('main', 'Заказ игрового хостинга серверов SAMP, CRMP. Доступны различные версии!');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="row">
                <div class="col-xlg-3 col-lg-3 col-md-3" itemscope itemtype="http://schema.org/SiteNavigationElement">
                    <?= $this->render('/_left') ?>
                </div>
                <div class="col-xlg-9 col-lg-9 col-md-9">
                    <div class="card-body">
                        <h1 class="text-center"><?= Yii::t('main', 'Заказ игрового хостинга') ?></h1>
                        <ul class="nav nav-tabs profile-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#"><?= Yii::t('main', 'Игра') ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" href="#">
                                    <?= Yii::t('main', 'Версия') ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" href="#">
                                    <?= Yii::t('main', 'Расположение') ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" href="#"><?= Yii::t('main', 'Подтверждение') ?></a>
                            </li>
                        </ul>
                        <div class="events-content">
                            <div class="message-box" style="margin-right: 5%;">
                                <div class="message-widget m-t-20">
                                    <?php foreach ($games AS $game): ?>
                                        <a href="<?= Url::to(['/hosting/order/step-two', 'game_id' => $game->id]) ?>">
                                            <div class="user-img"><span
                                                        class="round <?= $availableColors[rand(0, count($availableColors) - 1)] ?>"><i
                                                            class="mdi mdi-gamepad-variant"></i></span></div>
                                            <div class="mail-contnet">
                                                <h5><?= $game->short ?>: <?= $game->title ?></h5>
                                                <span class="mail-desc"><?= Yii::t('main', 'Доступные версии') ?>:
                                                    <?php for ($i = 0; $i < count($game->versions); $i++): ?>
                                                        <b class="text-purple"><?= $game->versions[$i]->title ?></b><?= $i == (count($game->versions) - 1) ? '.' : '; ' ?>
                                                    <?php endfor; ?>
                                            </span>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>