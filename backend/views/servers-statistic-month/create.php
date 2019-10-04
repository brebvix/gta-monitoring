<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ServersStatisticMonth */

$this->title = Yii::t('app', 'Create Servers Statistic Month');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Servers Statistic Months'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servers-statistic-month-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
