<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Servers */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Servers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servers-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'game_id',
                'value' => function ($model) {
                    return $model->game->title;
                }
            ],
            'ip',
            'port',
            'title',
            'title_eng',
            'mode',
            'language',
            'version',
            'site',
            'players',
            'maxplayers',
            'average_online',
            'maximum_online',
            'offline_count',
            'rating',
            'rating_up',
            'rating_down',
            'created_at',
            'status',
        ],
    ]) ?>

    <h1>Owners:</h1>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $model->serversOwners]),
        'columns' => [
                [
                    'attribute' => 'user_id',
                    'label' => 'Username',
                    'value' => function ($model) {
                        return $model->user->username;
                    }
            ],
        ],
    ]) ?>
</div>
