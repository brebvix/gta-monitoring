<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Servers */

$this->title = Yii::t('app', 'Create Servers');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Servers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
