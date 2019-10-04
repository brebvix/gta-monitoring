<?php

use yii\helpers\Html;
use common\models\ServersRating;
use common\models\Servers;

$server = Servers::findOne(['id' => $server_id]);
$user = \common\models\User::findOne(['id' => $activity->main_id]);
?>
<li class="<?= $inverted ? 'timeline-inverted' : '' ?>">
    <div class="timeline-badge <?= $rating_type == ServersRating::RATING_UP ? 'primary' : 'danger' ?>">
        <img class="img-responsive" alt="User <?= $user->username ?> avatar" src="<?= $user->getAvatarLink() ?>">
    </div>
    <div class="timeline-panel">
        <div class="timeline-heading">
            <div class="pull-right">
                <small> <?= Yii::$app->formatter->asRelativeTime(strtotime($activity->date)) ?></small>
            </div>
            <h4 class="timeline-title"><?= Yii::t('main', $rating_type == ServersRating::RATING_UP ? 'Понравился' : 'Не понравился') ?>
                <?= Yii::t('main', 'сервер') ?>
            </h4>
        </div>
        <div class="timeline-body">
            <p> <?= Yii::t('main', 'Пользователю') ?> <b><?= Html::a($username, ['/user/profile', 'id' => $activity->main_id]) ?></b>
                <?= Yii::t('main', $rating_type == ServersRating::RATING_UP ? 'понравился' : 'не понравился') ?>
                <?= Yii::t('main', 'сервер') ?> <?= Html::a($title, ['/server/view', 'id' => $server->id, 'game' => $server->game(), 'title_eng' => $server->title_eng]) ?>
            </p>
        </div>
    </div>
</li>