<?php

use yii\helpers\Url;

if (!isset($active)) {
    $active = '';
}

$symbol = strpos(Yii::$app->request->url, '?');
$symbol = $symbol === false ? '?' : '&';
$position = 0;
?>
<div class="col-xlg-3 col-lg-3 col-md-3" itemscope itemtype="http://schema.org/SiteNavigationElement">
    <div class="card-body inbox-panel">
        <?php if (!Yii::$app->user->isGuest): ?>
            <a href="<?= Url::to(['/freelance/services/add']) ?>"
               class="btn btn-danger m-b-20 p-10 btn-block waves-effect waves-light"><?= Yii::t('main', 'Добавить услугу') ?></a>
        <?php endif; ?>
        <ul class="list-group list-group-full" itemscope itemtype="http://schema.org/ItemList">
            <li class="list-group-item">
                <a href="<?= Url::to(['index?ServicesSearch%5Bvacancie_id%5D=']) ?>">
                    <i class="mdi mdi-account-multiple-outline"></i> <?= Yii::t('main', 'Все услуги') ?>
                </a>
            </li>
            <?php
            foreach ($vacancies_list AS $vacancie):
                $position++;
                ?>
                <li class="list-group-item <?= $active == $vacancie->id ? 'active' : '' ?>" itemprop="itemListElement"
                    itemscope itemtype="http://schema.org/ListItem">
                    <meta itemprop="position" content="<?= $position ?>"/>
                    <a itemprop="url" href="<?= Url::to(['?ServicesSearch%5Bvacancie_id%5D=' . $vacancie->id]) ?>">
                        <meta itemprop="name" content="<?= Yii::t('main', $vacancie->title) ?>" />
                        <?= $vacancie->icon ?> <?= Yii::t('main', $vacancie->title) ?>
                        <span class="badge badge-success ml-auto"><?= $vacancie->getFreelanceServicesCount() ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>