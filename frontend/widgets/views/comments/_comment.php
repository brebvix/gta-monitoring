<?php

use yii\helpers\Url;
use common\models\Comments;

?>

<div class="sl-item ribbon-wrapper-reverse" itemprop="review" itemscope itemtype="http://schema.org/Review">
        <div>
            <?php if ($model->type_positive == Comments::NEGATIVE): ?>
                <div class="ribbon ribbon-corner ribbon-right ribbon-danger font-20"><i class="mdi mdi-emoticon-poop"></i></div>
            <?php else: ?>
                <div class="ribbon ribbon-corner ribbon-right ribbon-success font-20"><i class="mdi mdi-checkbox-marked-circle-outline"></i></div>
            <?php endif; ?>
            <p class="m-t-10 text-justify">
                <a href="<?= Url::to(['/user/profile', 'id' => $model->author->id]) ?>" data-pjax="0" class="link">
                <img src="<?= $model->author->getAvatarLink() ?>" alt="User <?= $model->author->username ?> avatar" style="width:40px;" class="img-circle pull-left m-r-10" />
                    <span itemprop="author" itemscope itemtype="http://schema.org/Person">
                        <span itemprop="name"><?= $model->author->username ?></span>
                    </span>
                </a>: <span itemprop="reviewBody"><?= $model->text ?></span></p>
            <meta itemprop="datePublished" content="<?= date('Y-m-d', strtotime($model->date)) ?>" />
            <span class="sl-date">
                <?= Yii::$app->formatter->asRelativeTime(strtotime($model->date)) ?>
            </span>
            |
            <span class="">
                <a class="text-success" href="<?= Url::to(['/rating/comment-up', 'comment_id' => $model->id]) ?>"> <i class="mdi mdi-thumb-up"></i></a>
                <?= $model->rating ?>
                <a class="text-danger" href="<?= Url::to(['/rating/comment-down', 'comment_id' => $model->id]) ?>" data-pjax="0"><i class="mdi mdi-thumb-down"></i></a>
            </span>
            <div style="float: right">
            </div>
        </div>
</div>