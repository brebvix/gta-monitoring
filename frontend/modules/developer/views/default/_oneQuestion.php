<?php
use yii\helpers\Url;

$url = Url::to(['/developer/questions/view', 'id' => $model->id, 'title' => $model->title_eng, 'category' => $model->category->parent->title_eng, 'child_category' => $model->category->title_eng]);
?>
<div class="col-xlg-6 col-lg-12 col-md-12 col-sm-12">
    <div class="card">
        <div class="card-body card-question" data-href="<?= $url ?>">
            <a href="<?= $url ?>"><h4><?= $model->title ?></h4></a>
            <p class="m-t-0 m-b-0" align="justify">
                <?= $model->short_message ?>
            </p>
            <div class="text-right">
                <?php foreach ($model->tags AS $tag): ?>
                    <a href="<?= Url::to(['/developer/questions/tag',  'tag' => $tag->tag->title_eng]) ?>" class="badge badge-inverse m-b-5"><?= $tag->tag->title ?></a>
                <?php endforeach; ?>
            </div>
            <div class="d-flex">
                <div class="read">
                    <?php if (!empty($model->category->parent)): ?>
                        <a href="<?= Url::to(['/developer/questions/category/', 'category' => $model->category->parent->title_eng]) ?>"
                           class="font-14"><span class="label label-<?= $model->category->parent->color ?>"><?= $model->category->parent->title ?></span></a>
                        <a href="<?= Url::to(['/developer/questions/child-category/', 'category' => $model->category->parent->title_eng, 'child' => $model->category->title_eng]) ?>"
                           class="font-14"><span class="label label-<?= $model->category->color ?>"><?= Yii::t('questions', $model->category->title) ?></span></a>
                    <?php endif;?>
                </div>
                <div class="ml-auto font-14">
                    <a href="#" class="link m-r-10" data-toggle="tooltip" title="<?= Yii::t('questions', 'Ответы') ?>"><i class="mdi mdi-comment-processing"></i> <?= $model->answers_count ?></a>
                    <a href="#" class="link m-r-10" data-toggle="tooltip" title="<?= Yii::t('questions', 'Просмотры') ?>"><i class="mdi mdi-owl"></i> <?= $model->views_count ?></a>
                    <a href="#" class="link" data-toggle="tooltip" title="<?= Yii::t('questions', 'Опубликовано') ?>">
                        <i class="mdi mdi-timer"></i>
                        <?= Yii::$app->formatter->asRelativeTime($model->date) ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>