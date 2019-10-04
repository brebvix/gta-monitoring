<?php

use yii\widgets\ListView;

$this->title = Yii::t('main', 'Исполнители / Фриланс');
Yii::$app->params['breadcrumbs'][] =  Yii::t('main', 'Фриланс');
Yii::$app->params['breadcrumbs'][] =  Yii::t('main', 'Исполнители');

Yii::$app->params['description'] = Yii::t('main', 'Заказать фриланс услуги в сфере SAMP, CRMP, MTA, FiveM, RAGE Multiplayer');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="row">
                <?= $this->render('_left', ['vacancies_list' => $vacancies_list, 'active' => $active]) ?>
                <div class="col-xlg-9 col-lg-9 col-md-9">
                    <br>
                    <ul class="card-body list-unstyled">
                        <?= ListView::widget([
                            'dataProvider' => $dataProvider,
                            'itemView' => '_one',
                            'itemOptions' => [
                                'tag' => false,
                            ],
                            'summary' => false,
                            'emptyText' => Yii::t('main', 'Услуги не найдены.'),
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
                        ]) ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>