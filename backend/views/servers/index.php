<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Games;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ServersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Servers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servers-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Servers'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute'=>'game_id',
                'filter'=> ArrayHelper::map(Games::find()->asArray()->all(), 'id', 'title'),
                'value' => function($model, $key, $index, $column) {
                    return $model->game->title;
                }
            ],
            'ip',
            'port',
            'title',
            //'title_eng',
            //'mode',
            //'language',
            //'version',
            //'site',
            //'players',
            //'maxplayers',
            //'average_online',
            //'maximum_online',
            //'offline_count',
            //'rating',
            //'rating_up',
            //'rating_down',
            //'created_at',
            //'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
