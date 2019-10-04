<?php

use common\models\Comments;
use yii\helpers\Url;

?>
<a href="<?= Url::to(['/user/profile', 'id' => Yii::$app->user->id, 'type' => 'comments']) ?>">
    <div class="btn btn-danger btn-circle"><i class="fa fa-commenting"></i></div>
    <div class="mail-contnet">
        <h6><?= Yii::t('main', 'Новый отзыв') ?></h6> <span
                class="mail-desc"><?= Yii::t('main', 'Пользователь') ?> <?= $username ?> <?= Yii::t('main', 'добавил вам') ?>
            <?= Yii::t('main', $type_positive == Comments::POSITIVE ? 'положительный' : 'отрицательный') ?> <?= Yii::t('main', 'отзыв') ?></span>
        <small
                class="time"><?= Yii::$app->formatter->asRelativeTime(strtotime($notification->date)) ?></small>
    </div>
</a>