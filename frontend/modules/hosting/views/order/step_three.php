<?php

use yii\helpers\Url;
use yii\widgets\ListView;

$this->registerJsFile('/template_assets/plugins/horizontal-timeline/js/horizontal-timeline.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerCssFile('/template_assets/plugins/horizontal-timeline/css/horizontal-timeline.css');

$this->title = Yii::t('main', 'Игровой хостинг ') . ' ' . $versionModel->title;
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Игровой хостинг'), 'url' => Url::to(['/hosting'])];
Yii::$app->params['breadcrumbs'][] = Yii::t('main', 'Заказ');
Yii::$app->params['breadcrumbs'][] = Yii::t('main', 'Шаг') . ' ' . 3;

Yii::$app->params['description'] = Yii::t('main', 'Заказ игрового хостинга') . ' ' . $versionModel->title
    . Yii::t('main', ', выбор расположения сервера.');
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
                        <h1 class="text-center"><?= Yii::t('main', 'Выбор расположение сервера') ?></h1>
                        <ul class="nav nav-tabs profile-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="<?= Url::to(['/hosting/order']) ?>"><?= Yii::t('main', 'Игра') ?>
                                    <span class="badge badge-primary"><?= $gameModel->short ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="<?= Url::to(['/hosting/order/step-two', 'game_id' => $gameModel->id]) ?>"><?= Yii::t('main', 'Версия') ?>
                                    <span class="badge badge-primary"><?= $versionModel->title ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="#">
                                    <?= Yii::t('main', 'Расположение') ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" href="#"><?= Yii::t('main', 'Подтверждение') ?></a>
                            </li>
                        </ul>
                        <div class="events-content">
                            <div class="message-box" style="margin-right: 5%;">
                                <?php foreach ($locations AS $location): ?>
                                    <div class="message-widget m-t-20">
                                        <a href="<?= Url::to([
                                            '/hosting/order/step-four',
                                            'game_id' => $gameModel->id,
                                            'version_id' => $versionModel->id,
                                            'location_id' => $location->id
                                        ]) ?>">
                                            <div class="user-img"><span class="round bg-primary"><i
                                                            class="mdi mdi-server-security"></i></span></div>
                                            <div class="mail-contnet">
                                                <h5><?= $location->ip ?></h5> <span
                                                        class="mail-desc"><?= Yii::t('main', $location->title) ?></span>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
