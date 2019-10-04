<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\User;
use common\models\Servers;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ServersOwnerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Servers Owners');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servers-owner-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Servers Owner'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'username',
                'value' => function ($model) {
                    $user = User::findOne(['id' => $model->user_id]);
                    return isset($user->username) ? $user->username : null;
                }
            ],
            [
                'attribute' => 'server_title',
                'value' => function ($model) {
                    return Html::a($model->server->title, ['/servers/view', 'id' => $model->server->id]);
                },
                'format' => 'raw',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
