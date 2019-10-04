<?php

use yii\widgets\ListView;
use yii\helpers\Url;
use yii\widgets\Pjax;

Pjax::begin();

$game = '';
$this->title = Yii::t('main', 'Новости');
Yii::$app->params['description'] = Yii::t('main', 'Последние и самые горячие новости!');

if (!empty($activeCategory)) {
    $category = \common\models\NewsCategories::findOne(['title_eng' => $activeCategory]);
    if (!empty($category)) {
        Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Новости'), 'url' => Url::to(['/news'])];
        Yii::$app->params['breadcrumbs'][] = Yii::t('main', $category->title);

        echo '<h1 class="text-center">' . Yii::t('main', $category->title)  .'</h1>';

        $this->title = Yii::t('main', $category->title) . ' / ' . $this->title;
    } else {
        Yii::$app->params['breadcrumbs'][] = Yii::t('main', 'Новости');
    }
} else {
    echo '<h1 class="text-center">' . Yii::t('main', 'Новости') . '</h1>';

    Yii::$app->params['breadcrumbs'][] = Yii::t('main', 'Новости');
}

if (Yii::$app->request->isPjax) {
    $this->title .= ' / ' . Yii::t('main', 'Servers.Fun');

    echo '<title> ' . $this->title . '</title>';
}

?>
<ul class="nav nav-tabs profile-tab" role="tablist">
    <li class="nav-item"><a class="nav-link <?= empty($activeCategory) ? 'active' : '' ?>"
                            href="<?= Url::to(['/news']) ?>"><?= Yii::t('main', 'Все новости') ?> <span
                    class="badge badge-primary"><?= $newsCount ?></span></a>
    </li>
    <?php foreach ($newsCategories AS $category): ?>
        <li class="nav-item"><a class="nav-link <?= $activeCategory == $category->title_eng ? 'active' : '' ?>"
                                href="<?= Url::to(['/news/index', 'category' => $category->title_eng]) ?>"><?= Yii::t('main', $category->title) ?>
                <span class="badge badge-primary"><?= Yii::$app->language == 'ru-RU' ? $category->news_count : $category->news_count_eng ?></span></a>
        </li>
    <?php endforeach; ?>
</ul>
<br>
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_one',
    'summary' => false,
    'emptyText' => Yii::t('main', 'Новости не найдены.'),
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
<?php Pjax::end() ?>
