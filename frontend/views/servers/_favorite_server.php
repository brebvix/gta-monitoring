<?php

use yii\helpers\Html;
use common\models\AchievementsList;
use yii\helpers\Url;

$vip = '';

if ($model->server->vip == common\models\Servers::VIP_YES) {
    $vip = true;
}

if (!empty($model->server->background)) {
    $text1 = 'text-light';
    $text2 = 'text-white';
    $text3 = 'text-light';
} else {
    $text1 = 'text-muted';
    $text2 = '';
    $text3 = 'text-primary';
}

switch ($model->server->game_id) {
    case 1:
        $game = 'SAMP';
        $color = 'success';
        break;
    case 2:
        $game = 'CRMP';
        $color = 'primary';
        break;
    case 3:
        $game = 'FiveM';
        $color = 'light-primary';
        break;
    case 4:
        $game = 'MTA';
        $color = 'light-success';
        break;
    case 7:
        $game = 'RAGE Multiplayer';
        $color = 'light-warning';
        break;
}


$serverLink = Url::to(['/server/view', 'id' => $model->server->id, 'title_eng' => $model->server->title_eng, 'game' => $model->server->game()]);

$achievements = $model->server->achievements;
?>
<tr class="<?= $vip == true ? 'actived' : '' ?> <?= !empty($model->server->background) ? $model->server->background : '' ?> m-b-0" data-href="<?= $serverLink ?>">
    <td>
        <h2 class="font-light <?= $text3 ?> m-b-0"
            style="white-space: pre;"><?= number_format($model->server->rating, 2, '.', '') ?><sup class="<?= $text1 ?>"> / 10</sup></h2>
    </td>
    <td>
        <h5 class="<?= $text2 ?>"><?= $model->server->title ?><div class="pull-right label label-<?= $color ?>"><?= $game ?></div></h5>
        <small class="<?= $text1 ?>"><a class="<?= $text1 ?>" href="<?= $model->server->connectHref() ?>" target="_blank"><?= $model->server->ip ?>:<?= $model->server->port ?></a></small>
        <div class="pull-right">
            <?php if (!empty($achievements)): ?>
                <?php foreach ($achievements AS $achievement): ?>
                    <span style="font-size:14px;" data-toggle="tooltip"
                          title="<?= Yii::t('main', 'Достижение') ?>: <?= Yii::t('main', $achievement->achievement->description) ?>"
                          class="badge badge-<?= $achievement->achievement->type_positive == AchievementsList::TYPE_POSITIVE_YES ? 'success' : 'danger' ?>">
                                    <?= $achievement->achievement->icon ?>
                                </span>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </td>
    <td>
        <h2 class="font-light <?= $text2 ?> m-b-0" style="white-space: pre;"><?= $model->server->players ?> <span
                    class="<?= $text1 ?>">/ <?= $model->server->maxplayers ?></span></h2>
    </td>
    <td>
        <a href="<?= $serverLink  ?>" data-pjax="0" class="btn btn-primary btn-circle m-b-0 p-10 btn-block waves-effect waves-light">
            <i class="mdi mdi-link"></i>
        </a>
    </td>
</tr>