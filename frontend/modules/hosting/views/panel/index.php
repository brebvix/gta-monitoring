<?php

use yii\helpers\Url;
use yii\widgets\ListView;
use frontend\modules\hosting\models\HostingServers;

$this->title = Yii::t('main', 'Панель управления игровыми серверами');
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Игровой хостинг'), 'url' => Url::to(['/hosting'])];
Yii::$app->params['breadcrumbs'][] = Yii::t('main', 'Панель управления');

Yii::$app->params['description'] = Yii::t('main', 'Панель управления игровыми серверами');
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
                        <h1 class="text-center"><?= Yii::t('main', 'Панель управления серверами') ?></h1>
                        <?php if (empty($servers)): ?>
                            <div class="alert alert-warning"><?= Yii::t('main', 'Для аренды сервера нажмите по кнопке "Заказать сервер".') ?></div>
                        <?php else: ?>
                            <?php foreach ($servers AS $server): ?>
                                <a href="<?= Url::to(['/hosting/panel/view', 'server_id' => $server->id]) ?>"
                                   class="card text-secondary" style="margin-right: 5%;">
                                    <img class="" src="/images/api/1.jpg" style="height: 100px;">
                                    <div class="card-img-overlay" style="height:110px;">
                                        <h3 class="card-title text-white m-b-0 dl"><?= $server->game->title ?></h3>
                                        <span class="label label-<?= $server->status == HostingServers::STATUS_ACTIVE ? 'success' : 'danger' ?> pull-right">
                                <?= Yii::t('main', $server->status == HostingServers::STATUS_ACTIVE ? 'Работает' : 'Не работает') ?>
                            </span>
                                    </div>
                                    <div class="card-body weather-small">
                                        <div class="row">
                                            <div class="col-6 b-r align-self-center">
                                                <div class="d-flex">
                                                    <div class="display-6 text-purple"><i
                                                                class="mdi mdi-laptop-chromebook"></i>
                                                    </div>
                                                    <div class="m-l-20">
                                                        <h4 class="font-light text-purple m-b-0"><?= $server->location->ip . ':' . $server->port ?></h4>
                                                        <small><?= Yii::t('main', $server->location->title) ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3 b-r text-center">
                                                <h3 class="font-light m-b-0" id="slotsTitle"><?= $server->slots ?></h3>
                                                <small><?= Yii::t('main', 'Слотов') ?></small>
                                            </div>
                                            <div class="col-3 text-center">
                                                <h3 class="font-light m-b-0"
                                                    id="monthTitle"><?= Yii::$app->formatter->asRelativeTime($server->end_date) ?> </h3>
                                                <small><?= Yii::t('main', 'Окончание') ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>