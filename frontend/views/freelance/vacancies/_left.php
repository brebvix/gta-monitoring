<?php

use yii\helpers\Url;

if (!isset($active)) {
    $active = '';
}

$symbol = strpos(Yii::$app->request->url, '?');
$symbol = $symbol === false ? '?' : '&';
?>
<div class="col-xlg-3 col-lg-3 col-md-3">
    <div class="card-body inbox-panel">
        <?php if (!Yii::$app->user->isGuest): ?>
            <a href="<?= Url::to(['/freelance/vacancies/add']) ?>"
               class="btn btn-danger m-b-20 p-10 btn-block waves-effect waves-light"><?= Yii::t('main', 'Добавить вакансию') ?></a>
        <?php endif; ?>
        <ul class="list-group list-group-full">
            <li class="list-group-item">
                <a href="<?= Url::to(['index?VacanciesSearch[vacancie_id]=']) ?>">
                    <i class="mdi mdi-account-multiple-outline"></i> <?= Yii::t('main', 'Все вакансии') ?>
                </a>
            </li>
            <?php foreach ($vacancies_list AS $vacancie): ?>
                <li class="list-group-item <?= $active == $vacancie->id ? 'active' : '' ?>">
                    <a href="<?= Url::to(['?VacanciesSearch[vacancie_id]=' . $vacancie->id]) ?>">
                        <?= $vacancie->icon ?> <?= Yii::t('main', $vacancie->title) ?>
                        <span class="badge badge-success ml-auto"><?= $vacancie->getFreelanceVacanciesCount() ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>