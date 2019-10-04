<?php
use yii\helpers\Html;

?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

</head>
<body>
<div class="list-group" style="height: 100%;">
    <button type="button" class="list-group-item list-group-item-action bg-dark text-center">
        <?= Html::a($server->title, ['/server/view', 'id' => $server->id, 'title_eng' => $server->title_eng, 'game' => $server->game()], ['target' => '_blank', 'style' => 'color: #fff;']) ?>
    </button>
    <button type="button" class="list-group-item bg-secondary text-light list-group-item-action"><?= Yii::t('main', 'Игроки') ?> <span
            class="float-right"><?= $server->players ?> / <?= $server->maxplayers ?></span></button>
    <button type="button" class="list-group-item bg-secondary text-light list-group-item-action">
        <div class="progress">
            <div class="progress-bar bg-dark text-light" role="progressbar"
                 style="width: <?= ($server->maxplayers > 0) ? number_format($server->players * 100 / $server->maxplayers, 2, '.', '') : 0 ?>%;"
                 aria-valuenow="<?= ($server->maxplayers > 0) ? number_format($server->players * 100 / $server->maxplayers, 2, '.', '') : 0 ?>" aria-valuemin="0"
                 aria-valuemax="100"><?= ($server->maxplayers > 0) ? number_format($server->players * 100 / $server->maxplayers, 2, '.', '') : 0 ?>%
            </div>
        </div>
    </button>
    <button type="button" class="list-group-item bg-secondary text-light list-group-item-action"><?= Yii::t('main', 'Средний онлайн') ?> <span class="float-right"><?= $server->average_online ?></span></button>
    <button type="button" class="list-group-item bg-secondary text-light list-group-item-action"><?= Yii::t('main', 'Максимальный онлайн') ?> <span class="float-right"><?= $server->maximum_online ?></span></button>
    <button type="button" class="list-group-item bg-secondary text-light list-group-item-action"><?= Yii::t('main', 'Рейтинг') ?>
        <span class="float-right"><?= number_format($server->rating, 2, '.', '') ?> / 10</span>
    </button>
    <button type="button" class="list-group-item bg-secondary text-light list-group-item-action">
        <div class="progress">
            <div class="progress-bar bg-dark text-light" role="progressbar"
                 style="width: <?= $server->rating * 10 ?>%;"
                 aria-valuenow="<?= $server->rating * 10 ?>" aria-valuemin="0"
                 aria-valuemax="100"><?= number_format($server->rating, 2, '.', ' ') ?> из 10
            </div>
        </div>
    </button>
    <button type="button" class="list-group-item bg-secondary text-light list-group-item-action text-center"><a style="color:#fff;" href="<?= $server->connectHref() ?>"><?= $server->ip ?>:<?= $server->port ?></a></button>
    <button type="button" class="list-group-item list-group-item-action bg-secondary text-light text-right" disabled>
        <small><?= Html::a('servers.fun', 'https://servers.fun', ['target' => '_blank', 'style' => 'color: #fff;']) ?></small>
    </button>
</div>
</body>
</html>