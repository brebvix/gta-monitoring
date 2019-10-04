<?php

use yii\bootstrap\ActiveForm;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use common\models\Comments;
use yii\captcha\Captcha;

$this->registerJsFile('/js/jasny-bootstrap.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/template_assets/plugins/styleswitcher/jQuery.style.switcher.js', ['depends' => 'yii\web\JqueryAsset']);
?>
<?php if (!Yii::$app->user->isGuest): ?>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-material']]); ?>

    <?= $form->field($addCommentModel, 'text')->textarea() ?>
    <?= $form->field($addCommentModel, 'captcha')->widget(Captcha::className(), [    'options' => [
        'placeholder' => Yii::t('main', 'Введите код с картинки'),
        'class' => 'form-control',
    ],])->label(false) ?>
    <div class="pull-left">
        <input name="AddCommentForm[type_positive]" value="<?= Comments::NEGATIVE ?>" type="radio"
               id="radio_30" class="with-gap radio-col-red"/>
        <label for="radio_30"><?= Yii::t('main', 'Отрицательный') ?></label><br>
        <input name="AddCommentForm[type_positive]" value="<?= Comments::POSITIVE ?>" type="radio"
               id="radio_31" class="with-gap radio-col-blue" checked/>
        <label for="radio_31"><?= Yii::t('main', 'Положительный') ?></label><br>
    </div>
    <div class="pull-right m-t-5">
        <button type="input" class="btn btn-success" data-toggle="modal" data-target="#add-contact">
            <?= Yii::t('main', 'Добавить') ?> <?= Yii::t('main', $type == Comments::TYPE_USER ? 'отзыв' : 'комментарий') ?></button>
    </div>
    <br><br><br>
    <hr>
    <?php ActiveForm::end() ?>
<?php endif; ?>
<?php
Pjax::begin(['enablePushState' => false]);
$this->registerJs("$(document).ready(function() {
    $('.page-item').each(function() {
        $(this).find('a').addClass('page-link');
        $(this).find('span').addClass('page-link');
    });
});");
?>
<div class="profiletimeline">
    <?= ListView::widget([
        'dataProvider' => $provider,
        'itemView' => '_comment',
        'summary' => false,
        'emptyText' => Yii::t('main', 'Нет комментариев'),
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
    <?php Pjax::end(); ?>
    <br><br>
</div>