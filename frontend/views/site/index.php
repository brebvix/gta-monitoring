<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Games;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use common\models\Servers;

/* @var $this yii\web\View */

$page = (int)Yii::$app->request->get('page');

if ($page > 0) {
    $this->title = Yii::t('main', 'Список серверов') . ', ' . Yii::t('main', 'страница №') . $page;

    if (Yii::$app->request->isPjax) {
        $this->title .= Yii::t('main', 'Игровой мониторинг Servers.Fun');
    }

} else {
    $this->title = Yii::t('main', 'Список серверов');
}

Yii::$app->params['breadcrumbs'][] = $this->title;

echo '<h1 class="text-center">' . Yii::t('main','Список серверов в мониторинге') . '</h1>';

Pjax::begin();
$page = (int)Yii::$app->request->get('page');
if ($page > 0) {
    echo '<title>' . Yii::t('main', 'Список серверов') . ', ' . Yii::t('main', 'страница №') . $page . ' / ' . Yii::t('main', 'Игровой мониторинг Servers.Fun') . '</title>';
}
$this->registerJs("$(document).ready(function() {
    $('.page-item').each(function() {
        $(this).find('a').addClass('page-link');
        $(this).find('span').addClass('page-link');
    });
});");

echo '<div style="overflow-x:auto;">';
echo ListView::widget([
    'dataProvider' => $serversProvider,
    'itemOptions' => ['class' => 'item'],
    'layout' => "{summary}\n<table class=\"table table-clickable table-hover stylish-table\">
<thead><tr><td>" .  Yii::t('main', 'Рейтинг') ."</td><td>" . Yii::t('main', 'Сервер') ."</td><td>" . Yii::t('main', 'Игроки') ."</td><td></td></tr></thead>
<tbody>{items}</tbody></table>\n{pager}",
    'summary' => false,
    'sorter' => [
            'attributes' => ['title', 'players', 'rating'],
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
    'itemView' => '_server',
]);
?>
</div>
    <br><br>
<?php Pjax::end(); ?>