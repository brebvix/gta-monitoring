<?php

use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use frontend\modules\developer\widgets\CategoriesListWidget;
use kartik\select2\Select2;
use frontend\modules\developer\widgets\TagsWidget;

$this->title = Yii::t('questions', 'Добавление вопроса');

Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('questions', 'Список вопросов'), 'url' => ['/developer']];
Yii::$app->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('/js/plugins/markdown/Markdown.Converter.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/markdown/Markdown.Editor.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/markdown/Markdown.Sanitizer.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/markdown/resizer.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/js/plugins/markdown/Markdown.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerCssFile('/js/plugins/markdown/wmd.css', ['depends' => 'yii\web\JqueryAsset']);
?>
<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-3 col-xlg-3">
        <?= CategoriesListWidget::widget(); ?>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-9 col-xlg-9">
        <div class="card">
            <div class="card-body">
                <h2 class="text-center"><?= Yii::t('questions', 'Добавление вопроса') ?></h2>
                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-material']]); ?>
                <?= $form->field($model, 'title')->textInput() ?>
                <br>
                <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
                    'data' => $categoriesList,
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ]) ?>

                <br>

                <?= $form->field($model, 'tagsList')->widget(Select2::className(), [
                    'data' => $tagsList,
                    'options' => ['multiple' => true],
                    'pluginOptions' => [
                        'tags' => true,
                        'tokenSeparators' => [',', ' '],
                        'maximumInputLength' => 16
                    ],
                ]) ?>
                <hr>
                <div class="wmd-panel">
                    <div id="wmd-button-bar"></div>
                    <label for="answer_question_body" class="required"></label>

                    <?= $form->field($model, 'message')->textarea(['class' => 'wmd-input form-control m-t-0', 'id' => 'ask_question_body'])->label(false) ?>
                </div>

                <div id="wmd-preview" class="wmd-panel wmd-preview"></div>
                <div class="text-center">
                    <button class="btn btn-primary" type="submit"><?= Yii::t('questions', 'Задать вопрос') ?></button>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>