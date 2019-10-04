<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->registerJsFile('/template_assets/plugins/horizontal-timeline/js/horizontal-timeline.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/template_assets/plugins/ion-rangeslider/js/ion-rangeSlider/ion.rangeSlider.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/page_hosting_order.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerCssFile('/template_assets/plugins/horizontal-timeline/css/horizontal-timeline.css');
$this->registerCssFile('/template_assets/plugins/ion-rangeslider/css/ion.rangeSlider.css');
$this->registerCssFile('/template_assets/plugins/ion-rangeslider/css/ion.rangeSlider.skinNice.css');

$this->title = Yii::t('main', 'Заказ игрового хостинга');
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Игровой хостинг'), 'url' => Url::to(['/hosting'])];
Yii::$app->params['breadcrumbs'][] = Yii::t('main', 'Заказ');
Yii::$app->params['breadcrumbs'][] = Yii::t('main', 'Шаг') . ' ' . 4;

Yii::$app->params['description'] = Yii::t('main', 'Заказ игрового хостинга') . ' ' . $versionModel->title
    . ', ' . $locationModel->title . ', ' . Yii::t('main', '. Подтверждение заказа.');
?>
<div class="d-none">
    <span id="min_slots"><?= $gameModel->min_slots ?></span>
    <span id="max_slots"><?= $gameModel->max_slots ?></span>
    <span id="price_per_slot"><?= $gameModel->price ?></span>
    <span id="slots_text"><?= Yii::t('main', 'Слотов') ?></span>
    <span id="months_text"><?= Yii::t('main', 'Месяцев') ?></span>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="row">
                <div class="col-xlg-3 col-lg-3 col-md-3" itemscope itemtype="http://schema.org/SiteNavigationElement">
                    <?= $this->render('/_left') ?>
                </div>
                <div class="col-xlg-9 col-lg-9 col-md-9">
                    <div class="card-body">
                        <h1 class="text-center"><?= Yii::t('main', 'Подтверждение заказа') ?></h1>
                        <ul class="nav nav-tabs profile-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="<?= Url::to(['/hosting/order']) ?>"><?= Yii::t('main', 'Игра') ?>
                                    <span class="badge badge-primary"><?= $gameModel->short ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="<?= Url::to(['/hosting/order/step-two', 'game_id' => $gameModel->id]) ?>">
                                    <?= Yii::t('main', 'Версия') ?>
                                    <span class="badge badge-primary"><?= $versionModel->title ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="<?= Url::to(['/hosting/order/step-three', 'game_id' => $gameModel->id, 'version_id' => $versionModel->id]) ?>">
                                    <?= Yii::t('main', 'Расположение') ?>
                                    <span class="badge badge-primary"><?= Yii::t('main', $locationModel->title) ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="#"><?= Yii::t('main', 'Подтверждение') ?></a>
                            </li>
                        </ul>
                        <br>
                        <div class="card" style="margin-right: 5%;">
                            <img class="" src="/images/api/1.jpg" style="height: 100px;">
                            <div class="card-img-overlay" style="height:110px;">
                                <h3 class="card-title text-white m-b-0 dl"><?= $gameModel->title ?></h3>
                                <div class="pull-right">
                                    <span class="label label-primary"><?= $versionModel->title ?></span>
                                </div>
                            </div>
                            <div class="card-body weather-small">
                                <div class="row">
                                    <div class="col-8 align-self-center">
                                        <div class="d-flex">
                                            <div class="display-6 text-purple"><i class="mdi mdi-crosshairs-gps"></i>
                                            </div>
                                            <div class="m-l-20">
                                                <h1 class="font-light text-purple m-b-0"><?= $locationModel->ip ?></h1>
                                                <small><?= Yii::t('main', $locationModel->title) ?></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2 text-center">
                                        <h1 class="font-light m-b-0" id="slotsTitle"><?= $gameModel->min_slots ?></h1>
                                        <small><?= Yii::t('main', 'Слотов') ?></small>
                                    </div>
                                    <div class="col-2 text-center">
                                        <h1 class="font-light m-b-0" id="monthTitle">1</h1>
                                        <small><?= Yii::t('main', 'Месяцев') ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $form = ActiveForm::begin(); ?>
                        <?= $form->field($model, 'slots')->hiddenInput(['value' => $gameModel->min_slots])->label(false) ?>
                        <?= $form->field($model, 'months')->hiddenInput(['value' => 1])->label(false) ?>
                        <?= $form->field($model, 'game_id')->hiddenInput(['value' => $gameModel->id])->label(false) ?>
                        <?= $form->field($model, 'location_id')->hiddenInput(['value' => $locationModel->id])->label(false) ?>
                        <?= $form->field($model, 'version_id')->hiddenInput(['value' => $versionModel->id])->label(false) ?>
                        <div class="message-box" style="margin-right: 5%; margin-left: 3%;">
                            <div id="range_months"></div>
                        </div>
                        <br>
                        <div class="message-box" style="margin-right: 5%; margin-left: 3%;">
                            <div id="range_slots"></div>
                        </div>
                        <br>
                        <center style="margin-right: 5%;">
                            <button type="submit"
                                    class="btn btn-primary m-b-20 p-10 btn-block waves-effect waves-light">
                                <?= Yii::t('main', 'Заказать сервер за') ?> <span id="resultPrice">0</span> <i
                                        class="mdi mdi-currency-rub"></i>
                            </button>
                        </center>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
