<?php

use frontend\widgets\CommentsWidget;
use common\models\Comments;
use yii\helpers\Url;

$this->title = $news->title . ' / ' . Yii::t('main', 'Новости');
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Новости'), 'url' => ['/news/index']];
Yii::$app->params['breadcrumbs'][] = $news->title;

Yii::$app->params['description'] = strip_tags($news->short_text);
$newsUrl = Url::to(['/news/view', 'id' => $news->id, 'category' => $news->categorie->title_eng, 'title_eng' => $news->title_eng]);
?>
    <div class="card card-outline-inverse" itemscope itemtype="http://schema.org/NewsArticle">
        <div class="card-header">
            <h1 class="m-b-0 text-white" style="font-size:18px;" itemprop="headline"><?= $news->title ?>
                <small class="pull-right text-light"><?= Yii::$app->formatter->asRelativeTime($news->date) ?></small>
            </h1>
        </div>
        <div class="card-body" itemprop="description">
            <?= $news->full_text ?>
            <div class="share42init pull-right" data-image="https://servers.fun/images/logotype600.jpg" data-description="<?= $news->short_text ?>"></div>
        </div>
        <meta itemprop="datePublished" content="<?= date('Y-m-d', strtotime($news->date)) ?>" />
        <meta itemprop="dateModified" content="<?= date('Y-m-d', strtotime($news->date)) ?>" />
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
    </div>
    <hr>
<?php
$widgetResult = CommentsWidget::widget(['id' => $news->id, 'type' => Comments::TYPE_NEWS]);
if (is_string($widgetResult)) {
    echo $widgetResult;
}
?>