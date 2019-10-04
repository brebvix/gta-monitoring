<?php

use common\models\System;
use common\models\UserPayments;
use yii\helpers\Html;

$this->title = Yii::t('main', 'Баланс');
Yii::$app->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('/js/big.number.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/page_balance.js', ['depends' => 'yii\web\JqueryAsset']);
?>
<h2 class="text-center"><?= Yii::t('main', 'Ваш баланс') ?>
    : <?= number_format($user->balance, 0, '.', ' ') ?><?= Yii::t('main', 'р.') ?></h2>
<small class="pull-right"><?= Yii::t('main', 'Курс') ?>
    : <?= number_format(System::findOne(['key' => 'course_rub'])->value, 2, '.', ' ') ?><?= Yii::t('main', 'р.') ?>
</small>

<h3 class="text-muted"><?= Yii::t('main', 'Пополнение') ?></h3>
<ul class="nav nav-tabs profile-tab" role="tablist">
    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#free-kassa" role="tab">Free-Kassa</a>
    </li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" id="nav-statistic" href="#cryptonator"
                            role="tab"><?= Yii::t('main', 'Криптовалюта') ?></a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#payeer" role="tab">Payeer</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#perfect-money" role="tab">Perfect Money</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="free-kassa" role="tabpanel">
        <div class="card-body">
            <?= Html::beginForm(['/user/payment-free-kassa'], 'post', ['class' => 'form-material']); ?>
            <input type="number" class="form-control payment-amount" name="amount_rub"
                   placeholder="<?= Yii::t('main', 'Сумма пополнения, Руб.') ?>"
                   min="10" required>
            <h5 class="pull-right text-muted"><br><?= Yii::t('main', 'Будет зачислено:') ?> <span
                        class="payment-result-amount">0</span><?= Yii::t('main', 'р.') ?></h5>
            <br><br>
            <div class="text-center">
                <button class="btn btn-primary"><?= Yii::t('main', 'Пополнить с помощью') ?> Free-Kassa</button>
            </div>

            <?= Html::endForm() ?>
        </div>
    </div>
    <div class="tab-pane" id="cryptonator" role="tabpanel">
        <div class="card-body">
            <form method="GET" class="form-material" action="https://api.cryptonator.com/api/merchant/v1/startpayment">
                <input type="hidden" name="merchant_id"
                       value="bd11fef432bfb603d2fbad52923a4262">
                <input type="hidden" name="item_name" value="Payment # Servers.Fun">
                <input type="hidden" name="order_id" value="<?= Yii::$app->user->id ?>">
                <input type="hidden" name="invoice_currency" value="usd">
                <input type="hidden" name="language" value="ru">
                <input class="form-control payment-amount" name="invoice_amount" type="text"
                       placeholder="<?= Yii::t('main', 'Сумма пополнения, Руб.') ?>" required>
                <h5 class="pull-right text-muted"><br><?= Yii::t('main', 'Будет зачислено:') ?> <span
                            class="payment-result-amount">0</span><?= Yii::t('main', 'р.') ?>
                </h5>
                <br><br>
                <div class="text-center">
                    <button class="btn btn-primary"><?= Yii::t('main', 'Пополнить с помощью') ?> Cryptonator</button>
                </div>
            </form>
        </div>
    </div>
    <div class="tab-pane" id="payeer" role="tabpanel">
        <div class="card-body">
            <?= Html::beginForm(['/user/payment-payeer'], 'post', ['class' => 'form-material']); ?>
            <input type="number" class="form-control payment-amount" name="amount_rub"
                   placeholder="<?= Yii::t('main', 'Сумма пополнения, Руб.') ?>"
                   min="10" required>
            <h5 class="pull-right text-muted"><br><?= Yii::t('main', 'Будет зачислено:') ?> <span
                        class="payment-result-amount">0</span><?= Yii::t('main', 'р.') ?></h5>
            <br><br>
            <div class="text-center">
                <button class="btn btn-primary"><?= Yii::t('main', 'Пополнить с помощью') ?> Payeer</button>
            </div>

            <?= Html::endForm() ?>
        </div>
    </div>
    <div class="tab-pane" id="perfect-money" role="tabpanel">
        <div class="card-body">
            <?= Html::beginForm(['/user/payment-perfect-money'], 'post', ['class' => 'form-material']); ?>
            <input type="number" class="form-control payment-amount" name="amount_rub"
                   placeholder="<?= Yii::t('main', 'Сумма пополнения, Руб.') ?>"
                   min="10" required>
            <h5 class="pull-right text-muted"><br><?= Yii::t('main', 'Будет зачислено:') ?> <span
                        class="payment-result-amount">0</span><?= Yii::t('main', 'р.') ?></h5>
            <br><br>
            <div class="text-center">
                <button class="btn btn-primary"><?= Yii::t('main', 'Пополнить с помощью') ?> Perfect Money</button>
            </div>

            <?= Html::endForm() ?>
        </div>
    </div>
</div>
<hr>

<h4><?= Yii::t('main', 'История операций') ?></h4>
<table class="table stylish-table">
    <thead>
    <tr>
        <th colspan="2"><?= Yii::t('main', 'Сумма') ?></th>
        <th><?= Yii::t('main', 'Система оплаты') ?></th>
        <th><?= Yii::t('main', 'Статус, комментарий') ?></th>
        <th><?= Yii::t('main', 'Дата') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($payments AS $payment): ?>
        <tr>
            <td style="width:50px;"><img width="50" src="<?= $user->getAvatarLink() ?>"></td>
            <td>
                <h6><?= $payment->type == UserPayments::TYPE_INCREASE ? '+' : '-' ?> <?= $payment->amount_rub ?><?= Yii::t('main', 'р.') ?></h6>
                <small class="text-muted"><?= $payment->type == UserPayments::TYPE_INCREASE ? '+' : '-' ?> <?= $payment->amount_usd ?>
                    USD
                </small>
            </td>
            <td><?= $payment->payment_system ?></td>
            <?php if ($payment->type == UserPayments::TYPE_INCREASE): ?>
                <td><span class="label label-<?= $payment->statusIcon() ?>"><?= $payment->statusText() ?></span>
                    <?php if (!empty($payment->comment)): ?>
                        (<?= $payment->comment ?>)
                        <?php endif; ?>
                </td>
            <?php else: ?>
                <td><span class="label label-purple"><?= Yii::t('main', 'Списание') ?></span> (<?= $payment->comment ?>)
                </td>
            <?php endif; ?>
            <td><?= Yii::$app->formatter->asRelativeTime($payment->date) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>