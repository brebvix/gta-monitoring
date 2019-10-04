<?php

use yii\helpers\Html;

$user = \common\models\User::findOne(['id' => $activity->main_id]);
?>
<li class="<?= $inverted ? 'timeline-inverted' : '' ?>">
    <div class="timeline-badge primary"><img src="<?= $user->getAvatarLink() ?>" class="img-responsive" alt="User <?= $user->username ?> avatar"></div>
    <div class="timeline-panel">
        <div class="timeline-heading">
            <div class="pull-right">
                <small> <?= Yii::$app->formatter->asRelativeTime(strtotime($activity->date)) ?></small>
            </div>
            <h4 class="timeline-title"><?= Yii::t('main', 'Регистрация') ?></h4>
        </div>
        <div class="timeline-body">
            <p><?= Yii::t('main', 'Пользователь') ?>
                <b><?= Html::a($username, ['/user/profile', 'id' => $activity->main_id]) ?></b> <?= Yii::t('main', 'зарегистрировался на сайте') ?>
                </p>
        </div>
    </div>
</li>