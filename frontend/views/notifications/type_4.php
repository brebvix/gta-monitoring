<?php

use common\models\Comments;
use yii\helpers\Url;

?>
<a href="<?= Url::to(['advertising/banner/buy', 'position' => $banner_position]) ?>">
    <div class="btn btn-primary btn-circle"><i class="mdi mdi-star-circle"></i></div>
    <div class="mail-contnet">
        <h6><?= Yii::t('main', 'Окончание аренды баннера') ?></h6> <span
                class="mail-desc"><?= Yii::t('main', 'Срок аренды баннера №') ?> <?= $banner_position ?>
             <?= Yii::t('main', 'закончился.  По нему кликнули') ?> <?= $banner_clicks ?> <?= Yii::t('main', 'раз') ?>.
            </span>
        <small
                class="time"><?= Yii::$app->formatter->asRelativeTime(strtotime($notification->date)) ?></small>
    </div>
</a>