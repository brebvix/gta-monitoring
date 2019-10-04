<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\modules\developer\widgets\CategoriesListWidget;
use yii\widgets\ListView;
use frontend\modules\developer\widgets\TagsWidget;

Yii::$app->user->setReturnUrl(Yii::$app->request->getAbsoluteUrl());

$this->title = $question->title;

Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('questions', 'Список вопросов'), 'url' => ['/developer']];
Yii::$app->params['breadcrumbs'][] = $this->title;

Yii::$app->params['description'] = $question->category->parent->title . ', ' . Yii::t('questions', $question->category->title) .' «' . $this->title .'»';

if (!Yii::$app->user->isGuest) {
    $this->registerJsFile('/js/plugins/markdown/Markdown.Converter.js', ['depends' => 'yii\web\JqueryAsset']);
    $this->registerJsFile('/js/plugins/markdown/Markdown.Editor.js', ['depends' => 'yii\web\JqueryAsset']);
    $this->registerJsFile('/js/plugins/markdown/Markdown.Sanitizer.js', ['depends' => 'yii\web\JqueryAsset']);
    $this->registerJsFile('/js/plugins/markdown/resizer.js', ['depends' => 'yii\web\JqueryAsset']);
    $this->registerJsFile('/js/plugins/markdown/Markdown.js', ['depends' => 'yii\web\JqueryAsset']);
    $this->registerCssFile('/js/plugins/markdown/wmd.css', ['depends' => 'yii\web\JqueryAsset']);
}

$this->registerJsFile('/js/plugins/highlight/highlight.pack.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerCssFile('/js/plugins/highlight/styles/default.css');

$this->registerJs('hljs.initHighlightingOnLoad();', 3);
?>
<div class="row" itemscope itemtype="http://schema.org/QAPage">
    <div class="col-sm-12 col-md-12 col-lg-3 col-xlg-3">
        <?= CategoriesListWidget::widget(); ?>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-9 col-xlg-9" itemscope itemtype="http://schema.org/Question">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-right m-t-0 text-center">
                            <h2 data-toggle="tooltip" title="<?= Yii::t('questions', 'Рейтинг') ?>" class="font-light" style="font-size:30px;">
                                <a href="<?= Url::to(['/developer/questions/rating', 'type' => 'down', 'id' => $question->id]) ?>" class="font-18 text-danger"><i class="mdi mdi-thumb-down"></i> </a>
                                <?= $question->rating ?>
                                <a href="<?= Url::to(['/developer/questions/rating', 'type' => 'up', 'id' => $question->id]) ?>" class="font-18 text-success"> <i class="mdi mdi-thumb-up"></i></a>
                            </h2>
                        </div>
                        <h1 class="text-center font-20" itemprop="name">
                            <?= $question->title ?>
                        </h1>
                        <div itemprop="text">
                        <?= \kartik\markdown\Markdown::process($question->message) ?>
                        </div>
                        <hr>
                        <div class="font-16">
                            <?= Yii::t('questions', 'Добавил') ?> <a
                                    href="<?= Url::to(['/user/profile', 'id' => $question->user->id]) ?>" itemprop="author" itemscope itemtype="http://schema.org/Person"><span itemprop="name"><?= $question->user->username ?></span></a>
                            |
                            <?= Yii::t('questions', 'Категории') ?>: <a
                                    href="<?= Url::to(['/developer/questions/category/', 'category' => $question->category->parent->title_eng]) ?>"
                                    class="font-14"><span
                                        class="label label-<?= $question->category->parent->color ?>"><?= $question->category->parent->title ?></span></a>
                            <a href="<?= Url::to(['/developer/questions/child-category/', 'category' => $question->category->parent->title_eng, 'child' => $question->category->title_eng]) ?>"
                               class="font-14"><span
                                        class="label label-<?= $question->category->color ?>"><?= Yii::t('questions', $question->category->title) ?></span></a>
                            <?php if (!empty($question->tags)): ?>
                                | <?= Yii::t('questions', 'Теги') ?>:
                                <?php foreach ($question->tags AS $tag): ?>
                                    <a href="<?= Url::to(['/developer/questions/tag', 'tag' => $tag->tag->title_eng]) ?>"
                                       class="badge badge-inverse m-b-5"><?= $tag->tag->title ?></a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <meta itemprop="answerCount" content="<?= $question->answers_count ?>" />
                            <div class="pull-right ml-auto font-14">
                                <a href="#" class="link m-r-10" data-toggle="tooltip" title="<?= Yii::t('questions', 'Ответы') ?>"><i
                                            class="mdi mdi-comment-processing"></i> <?= $question->answers_count ?></a>
                                <a href="#" class="link m-r-10" data-toggle="tooltip" title="<?= Yii::t('questions', 'Просмотры') ?>"><i
                                            class="mdi mdi-owl"></i> <?= $question->views_count ?></a>
                                <meta itemprop="dateCreated" content="<?= date('Y-m-d', strtotime($question->date)) ?>" />
                                <a href="#" class="link" data-toggle="tooltip" title="<?= Yii::t('questions', 'Опубликовано') ?>">
                                    <i class="mdi mdi-timer"></i>
                                    <?= Yii::$app->formatter->asRelativeTime($question->date) ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer font-14">
                <?php if (!Yii::$app->user->isGuest): ?>
                    <div id="accordion3" role="tablist" class="minimal-faq" aria-multiselectable="true">
                        <div class="pull-right">
                            <button class="btn btn-circle btn-primary" role="tab" id="headingOne12" data-toggle="collapse"
                                    data-parent="#accordion3" href="#collapseOne12" aria-expanded="false"
                                    aria-controls="collapseOne12"><i class="mdi mdi-comment-plus-outline"></i></button>
                        </div>
                        <div id="collapseOne12" class="collapse" role="tabpanel" aria-labelledby="headingOne12"
                             style="">
                            <div class="card-body">
                                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-material']]); ?>
                                <?= $form->field($commentModel, 'answer_id')->hiddenInput(['value' => -1])->label(false); ?>
                                <?= $form->field($commentModel, 'text')->textarea() ?>
                                <div class="text-center">
                                    <button class="btn btn-primary"><?= Yii::t('questions', 'Добавить') ?></button>
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php foreach ($question->comments AS $comment): ?>
                    <p>
                        <a href="<?= Url::to(['/user/profile', 'id' => $comment->user_id]) ?>"><?= $comment->user->username ?></a>, <?= Yii::$app->formatter->asRelativeTime($comment->date) ?>
                        : <?= $comment->text ?></p>
                <?php endforeach; ?>
            </div>
        </div>
        <?php if (!Yii::$app->user->isGuest): ?>
            <div id="accordion2" role="tablist" class="minimal-faq" aria-multiselectable="true">
                <div class="card">
                    <div class="card-header" role="tab" id="headingOne11" data-toggle="collapse"
                         data-parent="#accordion2" href="#collapseOne11" aria-expanded="false"
                         aria-controls="collapseOne11" style="cursor: pointer;margin: 0px;padding:10px;">
                        <h4 class="mb-0 text-center text-primary">
                            <?= Yii::t('questions', 'Добавить ответ') ?>
                        </h4>
                    </div>
                    <div id="collapseOne11" class="collapse" role="tabpanel" aria-labelledby="headingOne11" style="">
                        <div class="card-body">
                            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-material']]); ?>
                            <div class="wmd-panel">
                                <div id="wmd-button-bar"></div>
                                <label for="answer_question_body" class="required"></label>

                                <?= $form->field($answerModel, 'text')->textarea(['class' => 'wmd-input form-control m-t-0', 'id' => 'ask_question_body'])->label(false) ?>
                            </div>

                            <div id="wmd-preview" class="wmd-panel wmd-preview"></div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"><?= Yii::t('questions', 'Добавить ответ') ?></button>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="minimal-faq card">
                <div class="card-body" style="margin: 0px;padding: 10px;">
                    <h4 class="mb-0 text-center text-muted">
                        <a href="<?= Url::to(['/site/login']) ?>"><?= Yii::t('questions', 'Авторизуйтесь') ?></a> <?= Yii::t('questions', 'или') ?> <a
                                href="<?= Url::to(['/site/signup']) ?>"><?= Yii::t('questions', 'Зарегистрируйтесь') ?></a> <?= Yii::t('questions', 'чтобы добавить ответ') ?>
                    </h4>
                </div>
            </div>
        <?php endif; ?>

        <?= ListView::widget([
            'dataProvider' => $answersProvider,
            'itemView' => '_oneAnswer',
            'summary' => false,
            'emptyText' => Yii::t('questions', 'Ответы не найдены.'),
            'pager' => [
                'activePageCssClass' => 'active',
                'firstPageCssClass' => 'page-item',
                'lastPageCssClass' => 'page-item',
                'nextPageCssClass' => 'page-item',
                'pageCssClass' => 'page-item',
                'prevPageCssClass' => 'page-item',
                'options' => [
                    'class' => 'pagination pull-right',
                ],
            ],
        ]); ?>
    </div>
</div>
<br><br>