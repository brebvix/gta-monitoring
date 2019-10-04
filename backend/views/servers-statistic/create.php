<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ServersStatistic */

$this->title = Yii::t('app', 'Create Servers Statistic');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Servers Statistics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servers-statistic-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
