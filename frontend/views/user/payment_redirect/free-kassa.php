<?php
$this->registerJs("$('#free-kassa-checkout-form').submit();", $this::POS_READY);
?>

<h1 class="text-center text-muted"><?= Yii::t('main', 'Перенаправляем на оплату ...') ?></h1>
<div class="free-kassa-checkout">
    <form id="free-kassa-checkout-form" action="http://www.free-kassa.ru/merchant/cash.php" method="GET">
        <?= \yii\helpers\Html::hiddenInput('m', 88230) ?>
        <?= \yii\helpers\Html::hiddenInput('oa', $payment->amount_rub) ?>
        <?= \yii\helpers\Html::hiddenInput('o', $payment->id) ?>
        <?= \yii\helpers\Html::hiddenInput('s', md5(implode(':', [88230, $payment->amount_rub, '62fbbirg', $payment->id]))) ?>
        <?= \yii\helpers\Html::hiddenInput('em', \common\models\User::findOne(['id' => $payment->user_id])->email) ?>
        <?= \yii\helpers\Html::hiddenInput('lang', Yii::$app->language == 'ru-RU' ? 'ru' : 'en') ?>
    </form>
</div>
