<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\ServersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="servers-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'game_id') ?>

    <?= $form->field($model, 'ip') ?>

    <?= $form->field($model, 'port') ?>

    <?= $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'title_eng') ?>

    <?php // echo $form->field($model, 'mode') ?>

    <?php // echo $form->field($model, 'language') ?>

    <?php // echo $form->field($model, 'version') ?>

    <?php // echo $form->field($model, 'site') ?>

    <?php // echo $form->field($model, 'players') ?>

    <?php // echo $form->field($model, 'maxplayers') ?>

    <?php // echo $form->field($model, 'average_online') ?>

    <?php // echo $form->field($model, 'maximum_online') ?>

    <?php // echo $form->field($model, 'offline_count') ?>

    <?php // echo $form->field($model, 'rating') ?>

    <?php // echo $form->field($model, 'rating_up') ?>

    <?php // echo $form->field($model, 'rating_down') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
