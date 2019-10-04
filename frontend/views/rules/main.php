<?php
if (isset($hasTitle)) {
    $this->title = Yii::t('main', 'Правила сайта');

    Yii::$app->params['breadcrumbs'][] = Yii::t('main', 'Помощь');
    Yii::$app->params['breadcrumbs'][] = $this->title;

    Yii::$app->params['description'] = $this->title;
}
?>
<?= $this->render(Yii::$app->language == 'ru-RU' ? '_ru' : '_en') ?>