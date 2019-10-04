<?php

use common\models\Comments;
use yii\helpers\Url;

?>
<a href="<?= Url::to(['advertising/link/buy']) ?>">
    <div class="btn btn-primary btn-circle"><i class="mdi mdi-star-circle"></i></div>
    <div class="mail-contnet">
        <h6><?= Yii::t('main', 'Окончание покупки ссылки') ?></h6> <span
            class="mail-desc"><?= Yii::t('main', 'Срок покупки ссылки') ?> <i><?= $link_title ?></i>
            <?= Yii::t('main', 'закончился.  По ней кликнули') ?> <?= $link_clicks ?> <?= Yii::t('main', 'раз') ?>.
            </span>
        <small
            class="time"><?= Yii::$app->formatter->asRelativeTime(strtotime($notification->date)) ?></small>
    </div>
</a>