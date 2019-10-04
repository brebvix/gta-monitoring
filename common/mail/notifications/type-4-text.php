<?= Yii::t('main', 'Здравствуйте') ?>, <b><?= $username ?></b>.<br>
<?= Yii::t('main', 'Уведомляем Вас, что срок аренды баннера') ?> №<?= $banner_position ?>
(<?= $banner_size ?><?= !empty($banner_title) ? ', ' . $banner_title : '' ?>)
<?= Yii::t('main', 'закончился. За время аренды по нему кликнули') ?> <?= $banner_clicks ?>
<?= Yii::t('main', 'раз (дней аренды:') ?> <?= $banner_days ?>).
<?= Yii::t('main', 'Если Вы желаете продлить аренду, перейдите по ниже указанной ссылке:') ?><br>
<a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/advertising/banner/buy', 'position' => $banner_position]) ?>"><?= Yii::$app->urlManager->createAbsoluteUrl(['/advertising/banner/buy', 'position' => $banner_position]) ?></a>