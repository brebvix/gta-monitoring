<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\FreelanceVacanciesList */

$this->title = Yii::t('app', 'Create Freelance Vacancies List');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Freelance Vacancies Lists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="freelance-vacancies-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
