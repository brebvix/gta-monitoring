<?php

use yii\widgets\ActiveForm;

$this->title = Yii::t('main', 'Покупка ссылки');
Yii::$app->params['breadcrumbs'][] =  ['label' => Yii::t('main', 'Реклама'), 'url' => ['/advertising']];
Yii::$app->params['breadcrumbs'][] =  $this->title;

Yii::$app->params['description'] = $this->title . ' / ' . Yii::t('main', 'Реклама');

$this->registerJsFile('/js/page_buy_link.js', ['depends' => 'yii\web\JqueryAsset']);
?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-material']]) ?>
<div class="row">
    <div class="col-md-4">
        <h3 class="text-center text-muted"> <?= Yii::t('main', 'Цвет фона') ?></h3>
        <?= $form->field($model, 'background')->dropDownList([
            'bg-dark' => Yii::t('main', 'Черный'),
            'bg-danger' => Yii::t('main', 'Красный'),
            'bg-warning' => Yii::t('main', 'Желтый'),
            'bg-primary' => Yii::t('main', 'Фиолетовый'),
            'bg-info' => Yii::t('main', 'Голубой'),
            'bg-success' => Yii::t('main', 'Зеленый'),
            'bg-secondary' => Yii::t('main', 'Серый'),
        ], ['size' => 8, 'class' => 'form-control set_background'])
            ->label(false) ?>
    </div>
    <div class="col-md-4">
        <h3 class="text-center text-muted"> <?= Yii::t('main', 'Пример') ?></h3>
        <div class="list-group">
            <a href="#" id="resultLink" class="list-group-item resultLink"><?= Yii::t('main', '* Ваша ссылка *') ?></a>
        </div>
    </div>
    <div class="col-md-4">
        <h3 class="text-center text-muted"> <?= Yii::t('main', 'Цвет текста') ?></h3>
        <?= $form->field($model, 'text_color')->dropDownList([
            'text-light' => Yii::t('main', 'Светлый'),
            'text-dark' => Yii::t('main', 'Черный'),
            'text-danger' => Yii::t('main', 'Красный'),
            'text-warning' => Yii::t('main', 'Желтый'),
            'text-primary' => Yii::t('main', 'Фиолетовый'),
            'text-info' => Yii::t('main', 'Голубой'),
            'text-success' => Yii::t('main', 'Зеленый'),
            'text-muted' => Yii::t('main', 'Серый'),
        ], ['size' => 8, 'class' => 'form-control set_text_color'])
            ->label(false) ?>
    </div>
</div>
<br>
<?= $form->field($model, 'title')->textInput() ?>
<?= $form->field($model, 'link')->textInput() ?>
<?= $form->field($model, 'days')->textInput() ?>
<br>
<center>
    <button type="submit"
            class="btn btn-primary m-b-20 p-10 btn-block waves-effect waves-light"> <?= Yii::t('main', 'Купить за') ?>
        <span
                id="resultAmount">0</span><i class="mdi mdi-currency-rub"></i></button>
</center>
<?php ActiveForm::end(); ?>
