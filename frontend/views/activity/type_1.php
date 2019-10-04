<?php

use common\models\Comments;
use yii\helpers\Html;
use common\models\Servers;

if ($object_type == Comments::TYPE_SERVER) {
    $server = Servers::findOne(['id' => $object_id]);

    switch ($server->game_id) {
        case 1:
            $game_eng = 'samp';
            break;
        case 2:
            $game_eng = 'crmp';
            break;
        case 3:
            $game_eng = 'fivem';
            break;
        case 4:
            $game_eng = 'mta';
            break;
        case 7:
            $game_eng = 'rage-multiplayer';
            break;
    }
}

$user = \common\models\User::findOne(['id' => $activity->main_id]);
?>
<li class="<?= $inverted ? 'timeline-inverted' : '' ?>">
    <div class="timeline-badge <?= $type_positive == Comments::POSITIVE ? 'primary' : 'danger' ?>">
        <img class="img-responsive" alt="User <?= $user->username ?> avatar" src="<?= $user->getAvatarLink() ?>">
    </div>
    <div class="timeline-panel">
        <div class="timeline-heading">
            <div class="pull-right">
                <small> <?= Yii::$app->formatter->asRelativeTime($activity->date) ?></small>
            </div>
            <h4 class="timeline-title">
                <?= Yii::t('main', 'Добавлен') ?>
                <?= Yii::t('main', $object_type == Comments::TYPE_SERVER ? 'комментарий' : 'отзыв') ?>
            </h4>
        </div>
        <div class="timeline-body">
            <p> <?= Yii::t('main', 'Пользователь') ?>
                <b><?= Html::a($author, ['/user/profile', 'id' => $activity->main_id]) ?></b>
                <?= Yii::t('main', 'добавил') ?> <?= Yii::t('main', $type_positive == Comments::POSITIVE ? 'положительный' : 'отрицательный') ?>
                <?= Yii::t('main', $object_type == Comments::TYPE_SERVER ? 'комментарий серверу' : 'отзыв пользователю') ?>
                <b><?= Html::a($title, $object_type == Comments::TYPE_SERVER ? ['/server/view', 'id' => $object_id, 'game' => $game_eng, 'title_eng' => $server->title_eng] : ['/user/profile', 'id' => $object_id]) ?></b><br>
                <small><?= $text ?></small>
            </p>
        </div>
    </div>
</li>