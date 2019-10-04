<?php

use yii\helpers\Html;
use common\models\AchievementsList;
use yii\helpers\Url;

$vip = '';

if ($model->vip == common\models\Servers::VIP_YES) {
    $vip = true;
}

if (!empty($model->background)) {
    $text1 = 'text-light';
    $text2 = 'text-white';
    $text3 = 'text-light';
} else {
    $text1 = 'text-muted';
    $text2 = '';
    $text3 = 'text-primary';
}

switch ($model->game_id) {
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

if ($model->game_id == 7 & $model->language == 'en') {
    $model->language = 'us';
}

$serverLink = Url::to(['/server/view', 'id' => $model->id, 'title_eng' => $model->title_eng, 'game' => $model->game()]);

$achievements = $model->achievements;
?>
<tr class="<?= $vip == true ? 'actived' : '' ?> <?= !empty($model->background) ? $model->background : '' ?> m-b-0"
    data-href="<?= $serverLink ?>" itemscope itemtype="http://schema.org/Product">
    <td>
        <div class="d-none" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
            <meta class="event-price" itemprop="price" content="0" />
            <meta itemprop="priceCurrency" content="USD" />
            <a itemprop="url" href="<?= $serverLink ?>"><?= $model->title ?></a>
        </div>
        <meta itemprop="description" content="Server <?= $model->title ?>">
        <h2 itemprop="aggregateRating"
            itemscope itemtype="http://schema.org/AggregateRating" class="font-light <?= $text3 ?> m-b-0"
            style=""><span style="white-space: pre;"><span
                        itemprop="ratingValue"><?= number_format($model->rating, 2, '.', '') ?></span><sup
                        class="<?= $text1 ?>"> / 10</sup></span>
            <meta itemprop="worstRating" content="0"/>
            <meta itemprop="bestRating" content="10"/>
            <meta itemprop="ratingCount" content="<?= round($model->rating_up + $model->rating_down) ?>"/>
        </h2>
    </td>
    <td>
        <h5 class="<?= $text2 ?>"><?= $model->game_id == 7 ? '<i class="flag-icon flag-icon-' . $model->language . '"></i>' : '' ?>
            <span itemprop="name"><?= $model->title ?></span>
            <span class="pull-right label label-<?= $color ?>" itemprop="brand"><?= $game ?></span>
        </h5>
        <small class="<?= $text1 ?>"><a class="<?= $text1 ?>" href="<?= $model->connectHref() ?>"
                                        target="_blank"><?= $model->ip ?>:<?= $model->port ?></a></small>
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
        <h2 class="font-light <?= $text2 ?> m-b-0" style="white-space: pre;"><?= $model->players ?> <span
                    class="<?= $text1 ?>">/ <?= $model->maxplayers ?></span></h2>
    </td>
    <td>
        <a itemprop="url" href="<?= $serverLink ?>" data-pjax="0"
           class="btn btn-primary btn-circle m-b-0 p-10 btn-block waves-effect waves-light">
            <i class="mdi mdi-link"></i>
        </a>
    </td>
</tr>