<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\models\FreelanceVacancies;

?>
<li class="media">
    <span class="d-flex mr-3" style="font-size: 64px;"><?= $model->vacancie->icon ?></span>
    <a href="<?= Url::to(['/freelance/vacancies/view', 'id' => $model->id]) ?>" class="media-body">
        <h5 class="text-left mt-0 mb-1">
            <?= $model->user->username ?> <?= Yii::t('main', 'ищет') ?> <span
                    class="badge badge-<?= $model->vacancie->getBadge() ?>"><?= Yii::t('main', $model->vacancie->title) ?></span>
            <?= Yii::t('main', 'для') ?> <?= Yii::t('main', $model->work_time == FreelanceVacancies::WORK_TEMP ? 'временного' : 'долгосрочного') ?>
            <?= Yii::t('main', 'сотрудничества') ?>
            <small class="text-muted pull-right"><?= Yii::$app->formatter->asRelativeTime($model->date) ?></small>
        </h5>
        <span class="text-muted"><?= $model->title ?></span>
    </a>
</li>