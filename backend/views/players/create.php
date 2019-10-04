<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Players */

$this->title = Yii::t('main', 'Create Players');
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Players'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="players-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
