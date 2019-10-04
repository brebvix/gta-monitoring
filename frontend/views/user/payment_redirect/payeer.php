<h1 class="text-center text-muted"><?= Yii::t('main', 'Перенаправляем на оплату ...') ?></h1>
<?php
echo \yiidreamteam\payeer\RedirectForm::widget([
    'api' => Yii::$app->get('payeer'),
    'invoiceId' => $payment->id,
    'amount' => $payment->amount_usd,
    'description' => 'Payment # Servers.Fun',
]);