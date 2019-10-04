<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\models\FreelanceVacancies;


?>
<li class="media" itemscope itemtype="https://schema.org/Service">
    <span class="d-flex mr-3" style="font-size: 64px;"><?= $model->vacancie->icon ?></span>
    <a itemprop="mainEntityOfPage" href="<?= Url::to(['/freelance/services/view', 'id' => $model->id]) ?>" class="media-body">
        <h5 class="text-left mt-0 mb-1">
            <?= $model->user->username ?> <?= Yii::t('main', 'предлагает услугу') ?> <span
                    class="badge badge-<?= $model->vacancie->getBadge() ?>" itemprop="serviceType"><?= Yii::t('main', $model->vacancie->title) ?></span>
            <small class="text-muted pull-right"><?= Yii::$app->formatter->asRelativeTime($model->date) ?></small>
        </h5>
        <span class="text-muted" itemprop="description"><?= $model->title ?></span>
    </a>
</li>