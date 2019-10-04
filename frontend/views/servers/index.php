<?php

use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$page = (int)Yii::$app->request->get('page');

switch ($game_id) {
    case 1:
        $game = 'SAMP';
        break;
    case 2:
        $game = 'CRMP';
        break;
    case 3:
        $game = 'FiveM';
        break;
    case 4:
        $game = 'MTA';
        break;
    case 7:
        $game = 'RAGE Multiplayer';
        break;
    default:
        $game = '';
        break;
}

if ($page > 0) {
    if (!empty($game)) {
        $this->title = Yii::t('main', '{game} сервера', ['game' => $game]) . ', ' . Yii::t('main', 'страница №') . $page;
    } else {
        $this->title = Yii::t('main', 'Игровой мониторинг') . ', ' . Yii::t('main', 'страница №') . $page;
    }

    if (Yii::$app->request->isPjax) {
        $this->title .= Yii::t('main', 'Servers.Fun');
    }
} else {
    if (!empty($game)) {
        $this->title = Yii::t('main', '{game} сервера', ['game' => $game]);
    } else {
        $this->title = Yii::t('main', 'Игровой мониторинг');
    }

    if (Yii::$app->request->isPjax) {
        $this->title .= ' / ' . Yii::t('main', 'Servers.Fun');
    }
}

Yii::$app->params['breadcrumbs'][] = Yii::t('main', empty($game) ? 'Игровой мониторинг' : '{game} сервера', ['game' => $game]);

Pjax::begin();
$this->registerJs("$('.table-clickable tr').on('click', function() {href = $(this).attr('data-href');  if (href.length > 0) { window.location = href;}});", 3);
$this->registerJs("$(document).ready(function() { $('.badge').tooltip();});", 3);
if ($game_id > 0) {
    echo '<h1 class="text-center">' . Yii::t('main', 'Список {game} серверов в мониторинге', ['game' => $game]) . '</h1>';
} else {
    echo '<h1 class="text-center">' . Yii::t('main', 'Список серверов в мониторинге') . '</h1>';
}
?>
    <ul class="nav nav-tabs profile-tab" role="tablist">
        <li class="nav-item"><a class="nav-link <?= empty($game) ? 'active' : '' ?>" href="<?= Url::to(['/']) ?>"><?= Yii::t('main', 'Все сервера') ?></a>
        </li>
        <li class="nav-item"><a class="nav-link <?= $game == 'SAMP' ? 'active' : '' ?>" href="<?= Url::to(['/servers/samp']) ?>">SAMP</a></li>
        <li class="nav-item"><a class="nav-link <?= $game == 'CRMP' ? 'active' : '' ?>" href="<?= Url::to(['/servers/crmp']) ?>">CRMP</a></li>
        <li class="nav-item"><a class="nav-link <?= $game == 'MTA' ? 'active' : '' ?>" href="<?= Url::to(['/servers/mta']) ?>">MTA</a></li>
        <li class="nav-item"><a class="nav-link <?= $game == 'FiveM' ? 'active' : '' ?>" href="<?= Url::to(['/servers/fivem']) ?>">FiveM</a></li>
        <li class="nav-item"><a class="nav-link <?= $game == 'RAGE Multiplayer' ? 'active' : '' ?>" href="<?= Url::to(['/servers/rage-multiplayer']) ?>">RAGE Multiplayer</a></li>
        <?php if (!Yii::$app->user->isGuest): ?>
            <li class="nav-item"><a class="nav-link" href="<?= Url::to(['/servers/favorites']) ?>"><?= Yii::t('main', 'Избранное') ?></a></li>
        <?php endif; ?>
    </ul>
<?php
$page = (int)Yii::$app->request->get('page');
if ($page > 0) {
    if (!empty($game)) {
        echo '<title>' . Yii::t('main', '{game} сервера', ['game' => $game]) . ', ' . Yii::t('main', 'страница №') . $page . ' / ' . Yii::t('main', 'Servers.Fun') . '</title>';
    } else {
        echo '<title>' . Yii::t('main', 'Игровой мониторинг') . ', ' . Yii::t('main', 'страница №') . $page . ' / ' . Yii::t('main', 'Servers.Fun') . '</title>';
    }
}
$this->registerJs("$(document).ready(function() {
    $('.page-item').each(function() {
        $(this).find('a').addClass('page-link');
        $(this).find('span').addClass('page-link');
    });
});");
echo '<div style="overflow-x:auto;">';
$sort = $serversProvider->getSort();
echo ListView::widget([
    'dataProvider' => $serversProvider,
    'itemOptions' => [
        'tag' => false,
    ],
    'layout' => "{summary}\n<table class=\"table table-clickable table-hover stylish-table\">
<thead><tr><td>" . Html::a(Yii::t('main', 'Рейтинг'), $sort->createUrl('rating')) . "</td><td>" . Yii::t('main', 'Сервер') . "</td><td>" . Html::a(Yii::t('main', 'Игроки'), $sort->createUrl('players')) . "</td><td></td></tr></thead>
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