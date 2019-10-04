<?php

use common\models\Comments;
use yii\helpers\Url;

?>
<a href="#">
    <div class="btn btn-danger btn-circle"><i class="fa fa-commenting"></i></div>
    <div class="mail-contnet">
        <h6><?= Yii::t('main', 'Авторизация') ?></h6> <span
                class="mail-desc"><?= Yii::t('main', 'Замечен вход в Ваш аккаунт с IP:') ?> <?= $ip ?>
            ; <?= Yii::t('main', 'Если это были не Вы - срочно обратитесь к администрации.') ?></span>
        <small
                class="time"><?= Yii::$app->formatter->asRelativeTime(strtotime($notification->date)) ?></small>
    </div>
</a>