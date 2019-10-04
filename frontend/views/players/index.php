<?php

use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('main', 'Поиск игроков на всех серверах');

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\PlayersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

Yii::$app->params['breadcrumbs'][] = Yii::t('main', 'Поиск игроков');
Yii::$app->params['description'] = Yii::t('main', 'Поиск игроков на серверах SAMP, CRMP, MTA, FiveM, RAGE Multiplayer, статистика, список серверов.');
?>
<h1 class="text-center"><?= Yii::t('main', 'Поиск игроков') ?></h1>
<?php
$form = ActiveForm::begin();
echo $form->field($formModel, 'nickname')->widget(Select2::classname(), [
    'options' => ['placeholder' => Yii::t('main', 'Поиск игроков ...')],
    'language' => Yii::$app->language,
    'pluginOptions' => [
        'language' => Yii::$app->language,
        'allowClear' => true,
        'minimumInputLength' => 3,
        'ajax' => [
            'url' => \yii\helpers\Url::to(['players-list']),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        'templateResult' => new JsExpression('function(player) {return player.text; }'),
        'templateSelection' => new JsExpression('function (player) {if (player.id !== undefined && player.id.length > 0) {window.location = "players/" + player.text + "/" + player.id;}return player.text;}'),
    ],
])->label(false);
ActiveForm::end();
?>
<hr>
<h2 class="text-center"><?= Yii::t('main', 'Недавно добавленные игроки') ?></h2>
<div class="players-index" style="overflow-x:auto;">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'tableOptions' => [
            'class' => 'table table-clickable table-hover stylish-table'
        ],
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
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'nickname',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(
                        $model['nickname'],
                        [
                            '/players/view',
                            'id' => $model['id'],
                            'nickname_eng' => $model['nickname_eng']
                        ],
                        [
                            'data-pjax' => 0,
                        ]);
                },
            ],
            [
                'attribute' => 'minutes',
                'format' => 'raw',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDuration($model['minutes'] * 60);
                }
            ],
            [
                'attribute' => 'date',
                'format' => 'raw',
                'value' => function ($model) {
                    return '<span data-toggle="tooltip" title="' . $model['date'] . '">' . Yii::$app->formatter->asRelativeTime($model['date']) . '</span>';
                }
            ],
        ],
    ]); ?>
</div>
