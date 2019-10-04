<?php
use yii\helpers\Url;
use frontend\modules\developer\widgets\CategoriesListWidget;
use yii\widgets\ListView;
use frontend\modules\developer\widgets\TagsWidget;

$this->title = $category . ' - ' . Yii::t('questions', 'вопросы и ответы');

Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('questions', 'Список вопросов'), 'url' => ['/developer']];
Yii::$app->params['breadcrumbs'][] = $category;

Yii::$app->params['description'] = $category . ', ' . Yii::t('questions', 'сервис вопросов и ответов.');

$this->registerCssFile('/template_assets/plugins/css-chart/css-chart.css');
$this->registerJsFile('/js/page_questions.js', ['depends' => 'yii\web\JqueryAsset']);
?>
<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-3 col-xlg-3">
        <?= CategoriesListWidget::widget(); ?>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-9 col-xlg-9">
        <div class="text-center">
            <h1><?= Yii::t('questions', 'Вопросы в категории') ?> <i><?= Yii::t('questions', $category) ?></i></h1>
        </div>
        <div class="row">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '/default/_oneQuestion',
                'summary' => false,
                'itemOptions' => [
                    'tag' => false
                ],
                'options' => [
                    'tag' => false,
                ],
                'emptyText' => '<div class="m-l-40">' . Yii::t('questions', 'Вопросы не найдены.') . '</div>',
                'pager' => [
                    'activePageCssClass' => 'active',
                    'firstPageCssClass' => 'page-item',
                    'lastPageCssClass' => 'page-item',
                    'nextPageCssClass' => 'page-item',
                    'pageCssClass' => 'page-item',
                    'prevPageCssClass' => 'page-item',
                    'options' => [
                        'class' => 'pagination pull-right',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>