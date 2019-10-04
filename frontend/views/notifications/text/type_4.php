<?php

use common\models\Comments;
use yii\helpers\Url;

?>
<?= Yii::t('main', 'Срок аренды баннера №') ?> <?= $banner_position ?>
 <?= Yii::t('main', 'закончился.  По нему кликнули') ?> <?= $banner_clicks ?> <?= Yii::t('main', 'раз') ?>.