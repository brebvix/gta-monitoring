<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AdvertisingBanners */

$this->title = Yii::t('app', 'Create Advertising Banners');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Advertising Banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertising-banners-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
