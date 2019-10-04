<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\FreelanceServices */

$this->title = Yii::t('app', 'Create Freelance Services');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Freelance Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="freelance-services-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
