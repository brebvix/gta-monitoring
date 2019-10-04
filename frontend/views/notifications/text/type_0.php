<?php

use common\models\Comments;
use common\models\CommentsRating;
use yii\helpers\Url;

?>
<?= Yii::t('main', 'Пользователю') ?> <?= $username ?>
 <?= Yii::t('main', $type_positive == CommentsRating::RATING_UP ? 'понравился' : 'не понравился') ?>
 <?= Yii::t('main', 'ваш') ?>
 <?= Yii::t('main', $comment_type == Comments::TYPE_SERVER ? 'комментарий' : 'отзыв') ?> <i><?= $comment_message ?></i>
