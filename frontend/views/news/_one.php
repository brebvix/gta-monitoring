<?php

use yii\helpers\Url;
use common\models\Comments;

$commentsCount = Comments::getCountById($model->id, Comments::TYPE_NEWS);
$newsUrl = Url::to(['/news/view', 'id' => $model->id, 'category' => $model->categorie->title_eng, 'title_eng' => $model->title_eng]);
?>
<div class="card card-outline-inverse">
    <article itemscope itemtype="http://schema.org/NewsArticle">
        <div class="card-header">
            <h4 class="m-b-0 text-white" itemprop="headline"><?= $model->title ?>
                <small class="pull-right text-light">
                    <i class="mdi mdi-owl"></i> <?= $model->views_count ?>
                    <i class="mdi mdi-timer"><?= Yii::$app->formatter->asRelativeTime($model->date) ?></i>
                </small>
            </h4>
        </div>
        <div class="card-body">
            <div itemprop="description"><?= $model->short_text ?></div>
            <div class="pull-left"><?= $commentsCount > 0 ? '<span class="badge badge-primary">' . Yii::t('main', 'Комментариев') . ': ' . $commentsCount . '</span>' : '' ?></div>
            <div class="pull-right">
                <a itemprop="url"
                   href="<?= $newsUrl ?>"
                   data-pjax="0" class="btn btn-primary"><?= Yii::t('main', 'Подробнее') ?></a>
            </div>
            <br>
        </div>
        <meta itemprop="datePublished" content="<?= date('Y-m-d', strtotime($model->date)) ?>" />
        <meta itemprop="dateModified" content="<?= date('Y-m-d', strtotime($model->date)) ?>" />
        <meta itemprop="author" content="Nazar Gavaga" />
        <div itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
            <meta itemprop="name" content="Servers.Fun" />
            <link itemprop="address" href="https://servers.fun<?= $newsUrl ?>" />
            <meta itemprop="telephone" content="+0(000)000-00-00" />
            <span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                <meta itemprop="image" content="https://servers.fun/images/logotype600.jpg" />
                <link itemprop="url" href="https://servers.fun<?= $newsUrl ?>" />
            </span>
        </div>
        <meta itemprop="image" content="https://servers.fun/images/logotype600.jpg" />
        <link itemprop="mainEntityOfPage" href="https://servers.fun<?= $newsUrl ?>" />
    </article>
</div>