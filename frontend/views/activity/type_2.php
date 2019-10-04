<?php

use yii\helpers\Html;
use common\models\CommentsRating;
use common\models\Comments;
use common\models\User;
$user = \common\models\User::findOne(['id' => $activity->main_id]);
?>
<li class="<?= $inverted ? 'timeline-inverted' : '' ?>">
    <div class="timeline-badge <?= $rating_type == CommentsRating::RATING_UP ? 'primary' : 'danger' ?>">
        <img class="img-responsive" alt="User <?= $user->username ?> avatar" src="<?= $user->getAvatarLink() ?>">
    </div>
    <div class="timeline-panel">
        <div class="timeline-heading">
            <div class="pull-right">
                <small> <?= Yii::$app->formatter->asRelativeTime(strtotime($activity->date)) ?></small>
            </div>
            <h4 class="timeline-title"><?= Yii::t('main', $rating_type == CommentsRating::RATING_UP ? 'Понравился' : 'Не понравился') ?>
                <?= Yii::t('main', 'комментарий') ?></h4>
        </div>
        <div class="timeline-body">
            <p> <?= Yii::t('main', 'Пользователю') ?>
                <b><?= Html::a($username, ['/user/profile', 'id' => $activity->main_id]) ?></b>
                <?= Yii::t('main', $rating_type == CommentsRating::RATING_UP ? 'понравился' : 'не понравился') ?>
                <?= Yii::t('main', 'комментарий') ?> <small><?= $comment_message ?></small>,  <?= Yii::t('main', 'пользователя') ?>
                <?= Html::a(User::findOne(['id' => $comment_author_id])->username, ['/user/profile', 'id' => $comment_author_id]) ?>
            </p>
        </div>
    </div>
</li>