<?php

use yii\helpers\Html;
use common\models\ServersRating;

?>
<li class="<?= $inverted ? 'timeline-inverted' : '' ?>">
    <div class="timeline-badge info">
        <i class="mdi mdi-star"></i>
    </div>
    <div class="timeline-panel">
        <div class="timeline-heading">
            <div class="pull-right">
                <small> <?= Yii::$app->formatter->asRelativeTime(strtotime($activity->date)) ?></small>
            </div>
            <h4 class="timeline-title"> <?= Yii::t('main', 'Получил достижение') ?></h4>
        </div>
        <div class="timeline-body">
            <p> <?= Yii::t('main', 'Пользователь') ?> <b><?= Html::a($username, ['/user/profile', 'id' => $activity->main_id]) ?></b>
                <?= Yii::t('main', 'получил достижение') ?> <b><?= Yii::t('main', $achievement_title) ?></b>
            </p>
        </div>
    </div>
</li>