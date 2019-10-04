<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

$this->title = Yii::t('main', 'Добавление сервера');
Yii::$app->params['breadcrumbs'][] = Yii::t('main', 'Сервера');
Yii::$app->params['breadcrumbs'][] = $this->title;

?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-material']]); ?>
<?= $form->field($addModel, 'ip')->textInput() ?>
<?= $form->field($addModel, 'port')->textInput() ?>
<br>
<?= $form->field($addModel, 'game_id')->widget(Select2::classname(), [
    'data' => [
        1 => 'SAMP',
        2 => 'CRMP',
        4 => 'MTA',
    ],
    'options' => ['placeholder' => Yii::t('main', 'Выберите игру ...')],
    'theme' => Select2::THEME_DEFAULT,
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label(false); ?>
<br>
<?= $form->field($addModel, 'reCaptcha')->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(false) ?>

<div class="text-center">
    <button type="submit" class="btn btn-success m-t-20"><i class="fa fa-plus"></i>
        <?= Yii::t('main', 'Добавить') ?>
    </button>
</div>
<?php ActiveForm::end() ?>
