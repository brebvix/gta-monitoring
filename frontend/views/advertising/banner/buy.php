<?php

use yii\bootstrap\ActiveForm;

$this->title = Yii::t('main', 'Аренда баннера');
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Реклама'), 'url' => ['/advertising']];
Yii::$app->params['breadcrumbs'][] = $this->title;

Yii::$app->params['description'] = $this->title . ' / ' . Yii::t('main', 'Реклама');

$size = explode('x', $banner->size);
$this->registerJsFile('/template_assets/plugins/dropify/dist/js/dropify.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJs('$(document).ready(function() {
        // Basic
        $(\'.dropify\').dropify();
        });', 3);
$this->registerCssFile('/template_assets/plugins/dropify/dist/css/dropify.min.css');
$this->registerJsFile('/js/page_buy_banner.js', ['depends' => 'yii\web\JqueryAsset']);
?>
<h2 class="text-center text-muted"> <?= Yii::t('main', 'Аренда баннера') ?> №<?= $banner->id ?></h2>
<span class="hidden d-none" id="bannerPrice"><?= $banner->price ?></span>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-material', 'enctype' => 'multipart/form-data']]) ?>
<?= $form->field($model, 'title')->textInput() ?>
<?= $form->field($model, 'days')->textInput() ?>
<?= $form->field($model, 'link')->textInput() ?>
<?= $form->field($model, 'banner_file')->fileInput(['class' => 'dropify', 'data-max-width' => $size[0] + 1, 'data-max-height' => $size[1] + 1])->label(false); ?>
<br>
<center>
    <button type="submit" class="btn btn-primary m-b-20 p-10 btn-block waves-effect waves-light">
        <?= Yii::t('main', 'Арендовать баннер за') ?> <span id="resultPrice">0</span> <i class="mdi mdi-currency-rub"></i>
    </button>
</center>
<?php ActiveForm::end(); ?>
