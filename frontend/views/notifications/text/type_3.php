<?php

use common\models\Comments;
use yii\helpers\Url;

?>
<?= Yii::t('main', 'Замечен вход в Ваш аккаунт с IP:') ?> <b><?= $ip ?></b>;  <?= PHP_EOL ?>
<?= Yii::t('main', 'Если это были не Вы - срочно обратитесь к администрации.') ?>