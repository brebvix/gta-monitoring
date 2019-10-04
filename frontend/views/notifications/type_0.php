<?php

use common\models\Comments;
use common\models\CommentsRating;
use yii\helpers\Url;

?>
<a href="<?= Url::to(['/user/profile', 'id' => Yii::$app->user->id, 'type' => 'comments']) ?>">
    <div class="btn btn-danger btn-circle"><?= $type_positive == CommentsRating::RATING_UP ? '<i class="fa fa-thumbs-o-up"></i>' : '<i class="fa fa-thumbs-o-down"></i>' ?></div>
    <div class="mail-contnet">
        <h6><?= Yii::t('main', 'Рейтинг комментария') ?></h6> <span class="mail-desc"><?= Yii::t('main', 'Пользователю') ?> <?= $username ?>
            <?= Yii::t('main', $type_positive == CommentsRating::RATING_UP ? 'понравился' : 'не понравился') ?>
            <?= Yii::t('main', 'ваш') ?>
            <?= Yii::t('main', $comment_type == Comments::TYPE_SERVER ? 'комментарий' : 'отзыв') ?> <i><?= $comment_message ?></i>
        </span>
        <small
                class="time"><?= Yii::$app->formatter->asRelativeTime(strtotime($notification->date)) ?></small>
    </div>
</a>