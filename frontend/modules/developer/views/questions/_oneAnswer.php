<?php
use yii\helpers\Url;
use \frontend\modules\developer\models\QuestionsComments;
use yii\widgets\ActiveForm;
use kartik\markdown\Markdown;

if (!Yii::$app->user->isGuest) {
    $commentModel = new QuestionsComments();
}
?>
<div class="card" itemprop="suggestedAnswer<?= $model->selected == 1 ? ' acceptedAnswer' : '' ?>" itemscope itemtype="http://schema.org/Answer">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="pull-right m-t-0 text-center">
                    <h2 data-toggle="tooltip" title="<?= Yii::t('questions', 'Рейтинг') ?>" class="font-light" style="font-size:30px;">
                        <a href="<?= Url::to(['/developer/questions/answer-rating', 'type' => 'down', 'id' => $model->id]) ?>" class="font-18 text-danger"><i class="mdi mdi-thumb-down"></i> </a>
                        <span itemprop="upvoteCount"><?= $model->rating ?></span>
                        <a href="<?= Url::to(['/developer/questions/answer-rating', 'type' => 'up', 'id' => $model->id]) ?>" class="font-18 text-success"> <i class="mdi mdi-thumb-up"></i></a>
                    </h2>
                </div>
                <br><br>
                <div itemprop="text"><?= Markdown::process($model->text) ?></div>
                <hr>
                <div class="font-16">
                    <?= Yii::t('questions', 'Ответил') ?>
                    <a itemprop="author" itemscope itemtype="http://schema.org/Person" href="<?= Url::to(['/user/profile', 'id' => $model->user->id]) ?>">
                        <span itemprop="name"><?= $model->user->username ?></span>
                    </a>

                    <div class="pull-right ml-auto font-14">
                        <meta itemprop="dateCreated" content="<?= date('Y-m-d', strtotime($model->date)) ?>" />
                        <a href="#" class="link" data-toggle="tooltip" title="<?= Yii::t('questions', 'Опубликовано') ?>">
                            <i class="mdi mdi-timer"></i>
                            <?= Yii::$app->formatter->asRelativeTime($model->date) ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link itemprop="url" href="https://servers.fun<?= Yii::$app->request->url?>" />
    <div class="card-footer font-14">
        <?php if (!Yii::$app->user->isGuest): ?>
            <div id="accordiona<?= $model->id ?>" role="tablist" class="minimal-faq" aria-multiselectable="true">
                <div class="pull-right">
                    <button class="btn btn-circle btn-primary" role="tab" id="headingOne12<?= $model->id ?>" data-toggle="collapse"
                            data-parent="#accordiona<?= $model->id ?>" href="#collapseOne12<?= $model->id ?>" aria-expanded="false"
                            aria-controls="collapseOne12<?= $model->id ?>"><i class="mdi mdi-comment-plus-outline"></i></button>
                </div>
                <div id="collapseOne12<?= $model->id ?>" class="collapse" role="tabpanel" aria-labelledby="headingOne12<?= $model->id ?>"
                     style="">
                    <div class="card-body">
                        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-material']]); ?>
                        <?= $form->field($commentModel, 'answer_id')->hiddenInput(['value' => $model->id])->label(false); ?>
                        <?= $form->field($commentModel, 'text')->textarea() ?>
                        <div class="text-center">
                            <button class="btn btn-primary"><?= Yii::t('questions', 'Добавить') ?></button>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php foreach ($model->comments AS $comment): ?>
            <p>
                <a href="<?= Url::to(['/user/profile', 'id' => $comment->user_id]) ?>"><?= $comment->user->username ?></a>, <?= Yii::$app->formatter->asRelativeTime($comment->date) ?>: <?= $comment->text ?></p>
        <?php endforeach; ?>
    </div>
</div>