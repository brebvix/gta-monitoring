<?php

use common\models\Comments;
use yii\helpers\Url;

?>
<a href="<?= Url::to(['/user/profile', 'id' => Yii::$app->user->id, 'type' => 'view-dialog', 'type_id' => $dialog_id]) ?>">
    <div class="btn btn-info btn-circle"><i class="fa fa-mail-forward"></i></div>
    <div class="mail-contnet">
        <h6><?= Yii::t('main', 'Новое сообщение') ?></h6> <span
                class="mail-desc"><?= Yii::t('main', 'Пользователь') ?> <?= $username ?> <?= Yii::t('main', 'оставил вам сообщение') ?>.</span>
        <small
                class="time"><?= Yii::$app->formatter->asRelativeTime(strtotime($notification->date)) ?></small>
    </div>
</a>