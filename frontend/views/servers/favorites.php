<?php
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */

$page = (int)Yii::$app->request->get('page');

if ($page > 0) {
    $this->title = Yii::t('main', 'Список избранных серверов');

    if (Yii::$app->request->isPjax) {
        $this->title .= Yii::t('main', 'Игровой мониторинг Servers.Fun');
    }

} else {
    $this->title =  Yii::t('main', 'Список избранных серверов');
}

Yii::$app->params['breadcrumbs'][] = $this->title;


Pjax::begin();
echo '<h1 class="text-center">' . Yii::t('main','Список избранных серверов') . '</h1>';
$this->registerJs("$('.table-clickable tr').on('click', function() {href = $(this).attr('data-href');  if (href.length > 0) { window.location = href;}});", 3);
$this->registerJs("$(document).ready(function() {
    $('.page-item').each(function() {
        $(this).find('a').addClass('page-link');
        $(this).find('span').addClass('page-link');
    });
});");
?>
    <ul class="nav nav-tabs profile-tab" role="tablist">
        <li class="nav-item"><a class="nav-link" href="<?= Url::to(['/']) ?>"><?= Yii::t('main', 'Все сервера') ?></a>
        </li>
        <li class="nav-item"><a class="nav-link" href="<?= Url::to(['/servers/samp']) ?>">SAMP</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= Url::to(['/servers/crmp']) ?>">CRMP</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= Url::to(['/servers/mta']) ?>">MTA</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= Url::to(['/servers/fivem']) ?>">FiveM</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= Url::to(['/servers/rage-multiplayer']) ?>">RAGE Multiplayer</a></li>
        <li class="nav-item"><a class="nav-link active" href="<?= Url::to(['/servers/favorites']) ?>"><?= Yii::t('main', 'Избранное') ?></a></li>
    </ul>
<?php
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
    'itemView' => '_favorite_server',
]);
?>
    </div>
    <br><br>
<?php Pjax::end(); ?>