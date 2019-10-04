<?php

use yii\helpers\Html;
use common\models\ServersRating;
$user = \common\models\User::findOne(['id' => $activity->main_id]);
?>
<li class="<?= $inverted ? 'timeline-inverted' : '' ?>">
    <div class="timeline-badge info">
        <img class="img-responsive" alt="User <?= $user->username ?> avatar" src="<?= $user->getAvatarLink() ?>">
    </div>
    <div class="timeline-panel">
        <div class="timeline-heading">
            <div class="pull-right">
                <small> <?= Yii::$app->formatter->asRelativeTime(strtotime($activity->date)) ?></small>
            </div>
            <h4 class="timeline-title"> <?= Yii::t('main', 'Добавил услугу') ?></h4>
        </div>
        <div class="timeline-body">
            <p> <?= Yii::t('main', 'Пользователь') ?> <b><?= Html::a($username, ['/user/profile', 'id' => $activity->main_id]) ?></b>
                <?= Yii::t('main', 'добавил услугу') ?> <?= Html::a(Yii::t('main', $service_category), ['/freelance/services/view', 'id' => $service_id]) ?>
            </p>
        </div>
    </div>
</li>