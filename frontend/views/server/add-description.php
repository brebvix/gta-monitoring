<?php
use yii\bootstrap\ActiveForm;
use kartik\markdown\MarkdownEditor;

$this->title = Yii::t('main', 'Добавление описания сервера');
Yii::$app->params['breadcrumbs'][] =  Yii::t('main', 'Сервера');
Yii::$app->params['breadcrumbs'][] =  $this->title;
?>
<h6 class="text-muted"><?= Yii::t('main', 'Минимальная длина описания составляет 400 символов.') ?></h6>
<?php
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

$form = ActiveForm::begin(['options' => ['class' => 'form-material']]);
?>
<?= MarkdownEditor::widget([
    'model' => $model,
    'attribute' => 'description',
    'toolbar' => $customToolbar
]); ?>

<div class="text-center">
    <button type="submit" class="btn btn-success m-t-20"><i class="fa fa-plus"></i>
        <?= Yii::t('main', 'Добавить') ?>
    </button>
</div>
<?php ActiveForm::end() ?>
