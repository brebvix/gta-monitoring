<?php

use common\models\Comments;
use yii\helpers\Url;

?>
<?= Yii::t('main', 'Срок покупки ссылки') ?> <i><?= $link_title ?></i>
 <?= Yii::t('main', 'закончился.  По ней кликнули') ?> <?= $link_clicks ?> <?= Yii::t('main', 'раз') ?>.