<?php

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use common\models\FreelanceVacancies;
use kartik\markdown\MarkdownEditor;

$this->title = Yii::t('main', 'Добавление');
Yii::$app->params['breadcrumbs'][] =  ['label' => Yii::t('main', 'Фриланс'), 'url' => ['/freelance/vacancies']];
Yii::$app->params['breadcrumbs'][] =  ['label' => Yii::t('main', 'Вакансии'), 'url' => ['/freelance/vacancies']];
Yii::$app->params['breadcrumbs'][] =  $this->title;

$heading = function ($n) {
    return [
        'label' => Yii::t('main', 'Заголовок {n}', ['n' => $n]),
        'options' => [
            'class' => 'kv-heading-' . $n,
            'title' => Yii::t('main', 'Заголовок {n} Стиль', ['n' => $n])
        ]
    ];
};

$customToolbar = [
    [
        'buttons' => [
            MarkdownEditor::BTN_BOLD => ['icon' => 'bold', 'title' => Yii::t('main', 'Выделение')],
            MarkdownEditor::BTN_ITALIC => ['icon' => 'italic', 'title' => Yii::t('main', 'Курсив')],
            MarkdownEditor::BTN_NEW_LINE => ['icon' => 'text-height', 'title' => Yii::t('main', 'Перенос строки')],
            MarkdownEditor::BTN_HEADING => ['icon' => 'header', 'title' => Yii::t('main', 'Заголовок'), 'items' => [
                MarkdownEditor::BTN_H3 => $heading(3),
                MarkdownEditor::BTN_H4 => $heading(4),
                MarkdownEditor::BTN_H5 => $heading(5),
                MarkdownEditor::BTN_H6 => $heading(6),
            ]],
        ],
    ],
    [
        'buttons' => [
            MarkdownEditor::BTN_UL => ['icon' => 'list', 'title' => Yii::t('main', 'Маркированный список')],
            MarkdownEditor::BTN_OL => ['icon' => 'list-alt', 'title' => Yii::t('main', 'Нумерованный список')],
        ],
    ],
    [
        'buttons' => [
            MarkdownEditor::BTN_QUOTE => ['icon' => 'comment', 'title' => Yii::t('main', 'Цитата')],
        ],
    ],
    [
        'buttons' => [
            MarkdownEditor::BTN_CODE => ['label' => MarkdownEditor::ICON_CODE, 'title' => Yii::t('main', 'Встроенный код'), 'encodeLabel' => false],
        ],
    ],
];

$vacanciesListForDropDown = [];

foreach ($vacancies_list AS $key => $value) {
    $vacanciesListForDropDown[$key] = Yii::t('main', $value->title);
}
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="row">
                <?= $this->render('_left', ['vacancies_list' => $vacancies_list]) ?>
                <div class="col-xlg-9 col-lg-9 col-md-9">
                    <br>
                    <div class="card-body p-t-0">
                        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-material']]); ?>
                        <?= $form->field($addModel, 'title')->textInput() ?>
                        <br>
                        <?= $form->field($addModel, 'payment')->textInput() ?>
                        <br>
                        <?= $form->field($addModel, 'vacancie_id')->widget(Select2::classname(), [
                            'data' => $vacanciesListForDropDown,
                            'options' => ['placeholder' => Yii::t('main', 'Выберите категорию ...')],
                            'theme' => Select2::THEME_DEFAULT,
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false); ?>
                        <br>
                        <?= $form->field($addModel, 'work_time')->widget(Select2::classname(), [
                            'data' => [
                                FreelanceVacancies::WORK_TEMP => Yii::t('main', 'Временная работа'),
                                FreelanceVacancies::WORK_ALL => Yii::t('main', 'Постоянная работа'),
                            ],
                            'options' => ['placeholder' => Yii::t('main', 'Выберите тип занятости ...')],
                            'theme' => Select2::THEME_DEFAULT,
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false); ?>
                        <br>
                        <?= MarkdownEditor::widget([
                            'model' => $addModel,
                            'attribute' => 'text',
                            'toolbar' => $customToolbar
                        ]); ?>

                        <br>
                        <?= $form->field($addModel, 'reCaptcha')->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(false) ?>

                        <div class="pull-right">
                            <button type="submit" class="btn btn-success m-t-20"><i class="fa fa-envelope-o"></i>
                                <?= Yii::t('main', 'Разместить вакансию') ?>
                            </button>
                        </div>
                        <?php ActiveForm::end(); ?>
                        <br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>