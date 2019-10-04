<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\FreelanceVacancies */

$this->title = Yii::t('app', 'Create Freelance Vacancies');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Freelance Vacancies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="freelance-vacancies-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
