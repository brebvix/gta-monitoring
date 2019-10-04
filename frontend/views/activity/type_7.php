<?php

use yii\helpers\Html;
use common\models\Servers;

$server = Servers::findOne(['id' => $activity->main_id]);
?>
<li class="<?= $inverted ? 'timeline-inverted' : '' ?>">
    <div class="timeline-badge info">
        <i class="mdi mdi-star-outline"></i>
    </div>
    <div class="timeline-panel">
        <div class="timeline-heading">
            <div class="pull-right">
                <small> <?= Yii::$app->formatter->asRelativeTime(strtotime($activity->date)) ?></small>
            </div>
            <h4 class="timeline-title"> <?= Yii::t('main', 'Получил достижение') ?></h4>
        </div>
        <div class="timeline-body">
            <p>
                <?= Yii::t('main', 'Сервер') ?> <b><?= Html::a($server_title, ['/server/view', 'id' => $activity->main_id, 'title_eng' => $server->title_eng, 'game' => $server->game()]) ?></b>
                <?= Yii::t('main', 'получил достижение') ?> <b><?= Yii::t('main', $achievement_title) ?></b>
            </p>
        </div>
    </div>
</li>