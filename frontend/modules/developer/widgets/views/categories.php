<?php

use yii\helpers\Url;
use frontend\modules\developer\widgets\TagsWidget;

if (isset(Yii::$app->params['activeCategory'])) {
    $activeCategory = Yii::$app->params['activeCategory'];
} else {
    $activeCategory = '';
}
$first = false;
$position = 0;
?>
<div class="card">
    <ul class="card-body list-style-none" style="padding:15px;" id="categoriesList" role="tablist"
        aria-multiselectable="true" itemscope itemtype="http://schema.org/ItemList">
        <li class="box-label"><a href="<?= Url::to(['/developer/questions/add']) ?>"><i
                        class="mdi mdi-plus"></i> <?= Yii::t('questions', 'Добавить вопрос') ?></a></li>
        <li class="divider"></li>
        <?php
        foreach ($categoriesList AS $category):
            $position++;
            ?>
            <div role="tab" id="category-heading-<?= $category->id ?>">
                <li data-toggle="collapse" data-parent="#categoriesList" href="#categorie-<?= $category->id ?>"
                    class="<?= $activeCategory == $category->id ? 'active' : '' ?>" aria-expanded="true"
                    aria-controls="categorie-<?= $category->id ?>" itemprop="itemListElement"
                    itemscope itemtype="http://schema.org/ListItem">
                    <meta itemprop="position" content="<?= $position ?>"/>
                    <a href="<?= Url::to(['/developer/questions/category', 'category' => $category->title_eng]) ?>" itemprop="url">
                        <meta itemprop="name" content="<?= $category->title ?>" />
                        <?= $category->title ?>
                        <span class="label label-<?= $category->color ?>"><?= $category->count ?></span>
                    </a>
                </li>
            </div>
            <div id="categorie-<?= $category->id ?>" class="collapse <?= $first == false ? 'show' : '' ?>"
                 class="collapse"
                 role="tabpanel" aria-labelledby="category-heading-<?= $category->id ?>" style="">
                <?php
                $first = true;
                foreach ($category->child AS $child):
                    $position++;
                    ?>
                    <li class="m-l-5 <?= $activeCategory == $child->id ? 'active' : '' ?>" itemprop="itemListElement"
                        itemscope itemtype="http://schema.org/ListItem">
                        <meta itemprop="position" content="<?= $position ?>"/>
                        <meta itemprop="name" content="<?= Yii::t('questions', $child->title) ?>" />

                        <a href="<?= Yii::$app->urlManager->createUrl([
                            '/developer/questions/child-category',
                            'category' => $category->title_eng,
                            'child' => $child->title_eng
                        ]) ?>" itemprop="url">
                            <?= Yii::t('questions', $child->title) ?>
                            <span class="label label-<?= $child->color ?>"><?= $child->count ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </ul>
    <hr>
    <div class="card-body">
        <?= TagsWidget::widget(); ?>
    </div>
</div>