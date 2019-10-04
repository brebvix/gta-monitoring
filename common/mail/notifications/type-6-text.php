<?= Yii::t('main', 'Здравствуйте') ?>, <b><?= $username ?></b>.<br>
<?= Yii::t('main', 'Уведомляем Вас, что время действия услуги закрепления сервера') ?>
<i><?= $server_title ?></i>
<?= Yii::t('main', 'в ТОПе закончилась. Если Вы желаете продлить закрепление сервера в ТОПе - перейдите по ниже указанной ссылке:') ?><br>
<a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/server/view', 'id' => $server_id]) ?>"><?= Yii::$app->urlManager->createAbsoluteUrl(['/server/view', 'id' => $server_id]) ?></a>