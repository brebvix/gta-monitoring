<?php

use yii\bootstrap\ActiveForm;

$this->title = Yii::t('main', 'Обратная связь');
Yii::$app->params['breadcrumbs'][] = Yii::t('main', 'Помощь');
Yii::$app->params['breadcrumbs'][] = $this->title;

Yii::$app->params['description'] = Yii::t('main', 'Обратная связь с администрацией');
?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-material']]); ?>
<?= $form->field($model, 'email')->textInput() ?>
<?= $form->field($model, 'body')->textarea(['rows' => 5]) ?>
<?= $form->field($model, 'reCaptcha')->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(false) ?>
<center>
    <button class="btn btn-primary"><?= Yii::t('main', 'Отправить') ?></button>
</center>
<?php ActiveForm::end(); ?>
