<?= Yii::t('main', 'Здравствуйте') ?>, <b><?= $username ?></b>.<br>
<?= Yii::t('main', 'Уведомляем Вас, что время действия услуги выделение цветом для сервера') ?>
<i><?= $server_title ?></i>
<?= Yii::t('main', 'закончилось. Если Вы желаете продлить выделение сервера цветом - перейдите по ниже указанной ссылке:') ?><br>
<a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/server/view', 'id' => $server_id]) ?>"><?= Yii::$app->urlManager->createAbsoluteUrl(['/server/view', 'id' => $server_id]) ?></a>