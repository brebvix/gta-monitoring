<?php

use yii\helpers\Html;
use yii\helpers\Url;
$user = \common\models\User::findOne(['id' => $activity->main_id]);
?>
<li class="<?= $inverted ? 'timeline-inverted' : '' ?>">
    <div class="timeline-badge primary">
        <img class="img-responsive" alt="User <?= $user->username ?> avatar" src="<?= $user->getAvatarLink() ?>">
    </div>
    <div class="timeline-panel">
        <div class="timeline-heading">
            <div class="pull-right">
                <small> <?= Yii::$app->formatter->asRelativeTime(strtotime($activity->date)) ?></small>
            </div>
            <h4 class="timeline-title"> <?= Yii::t('questions', 'Изменил рейтинг') ?></h4>
        </div>
        <div class="timeline-body">
            <p>
                <?= Yii::t('main', 'Пользователю') ?>
                <b><?= Html::a($username, ['/user/profile', 'id' => $activity->main_id]) ?></b>
                <?= Yii::t('questions', $type_positive == 'up' ? 'понравился' : 'не понравился') ?>
                <?= Yii::t('questions', 'вопрос') ?> «<?= Html::a($title, [
                    '/developer/questions/view',
                    'id' => $question_id,
                    'title' => $title_eng,
                    'category' => $parent_category_eng,
                    'child_category' => $category_eng,
                ]) ?>»
            </p>
        </div>
    </div>
</li>