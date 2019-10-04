<?php

use common\models\Comments;
use yii\helpers\Url;

?>
<a href="<?= Url::to(['server/view', 'id' => $server_id]) ?>">
    <div class="btn btn-primary btn-circle"><i class="mdi mdi-star-circle"></i></div>
    <div class="mail-contnet">
        <h6><?= Yii::t('main', 'Окончание выделения цветом') ?></h6> <span
            class="mail-desc"><?= Yii::t('main', 'Срок выделения цветом сервера') ?> <i><?= $server_title ?></i>
            <?= Yii::t('main', 'закончился.') ?>.
            </span>
        <small
            class="time"><?= Yii::$app->formatter->asRelativeTime(strtotime($notification->date)) ?></small>
    </div>
</a>