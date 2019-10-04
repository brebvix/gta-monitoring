<?php

use common\models\Comments;
use yii\helpers\Url;

?>
<?= Yii::t('main', 'Пользователь') ?> <?= $username ?> <?= Yii::t('main', 'добавил вам') ?>
 <?= Yii::t('main', $type_positive == Comments::POSITIVE ? 'положительный' : 'отрицательный') ?> <?= Yii::t('main', 'отзыв') ?>