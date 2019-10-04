<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ServersStatisticMonth */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="servers-statistic-month-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'server_id')->textInput() ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'average_online')->textInput() ?>

    <?= $form->field($model, 'maximum_online')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
