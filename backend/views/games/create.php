<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Games */

$this->title = Yii::t('app', 'Create Games');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Games'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="games-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
