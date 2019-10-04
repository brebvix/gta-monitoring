<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\FreelanceVacancies */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="freelance-vacancies-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'server_id') ?>

    <?= $form->field($model, 'vacancie_id') ?>

    <?= $form->field($model, 'text') ?>

    <?php // echo $form->field($model, 'payment') ?>

    <?php // echo $form->field($model, 'work_time') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
