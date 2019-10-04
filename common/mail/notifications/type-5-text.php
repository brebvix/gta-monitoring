<?= Yii::t('main', 'Здравствуйте') ?>, <b><?= $username ?></b>.<br>
<?= Yii::t('main', 'Уведомляем Вас, что срок аренды ссылки') ?> <?= $link_title ?>
<?= Yii::t('main', 'закончился. За время аренды по ней кликнули') ?> <?= $link_clicks ?>
<?= Yii::t('main', 'раз (дней аренды:') ?> <?= $link_days ?>).
<?= Yii::t('main', 'Если Вы желаете продлить аренду, перейдите по ниже указанной ссылке:') ?><br>
<a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/advertising/link/buy']) ?>"><?= Yii::$app->urlManager->createAbsoluteUrl(['/advertising/link/buy']) ?></a>