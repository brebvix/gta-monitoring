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
            <h4 class="timeline-title"> <?= Yii::t('questions', 'Добавил вопрос') ?></h4>
        </div>
        <div class="timeline-body">
            <p>
                <?= Yii::t('main', 'Пользователь') ?>
                <b><?= Html::a($username, ['/user/profile', 'id' => $activity->main_id]) ?></b>
                <?= Yii::t('questions', 'добавил вопрос') ?> «<?= Html::a($title, [
                    '/developer/questions/view',
                    'id' => $question_id,
                    'title' => $title_eng,
                    'category' => $parent_category_eng,
                    'child_category' => $category_eng,
                ]) ?>» <?= Yii::t('questions', 'в категорию') ?>
                <a href="<?= Url::to(['/developer/questions/category/', 'category' => $parent_category_eng]) ?>"
                   class="font-14"><span
                            class="label label-<?= $parent_category_color ?>"><?= $parent_category_title ?></span></a>
                <a href="<?= Url::to(['/developer/questions/child-category/', 'category' => $parent_category_eng, 'child' => $category_eng]) ?>"
                   class="font-14">
                    <span class="label label-<?= $category_color ?>"><?= Yii::t('questions', $category_title) ?></span></a>
            </p>
        </div>
    </div>
</li>