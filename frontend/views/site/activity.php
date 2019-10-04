<?php
$this->title = Yii::t('main', 'Активность на сайте');

Yii::$app->params['breadcrumbs'][] = $this->title;
Yii::$app->params['description'] = Yii::t('main', 'Активность на сайте');

$inverted = true;
?>
<ul class="timeline">
    <?php
    foreach ($data AS $activity) {
        $inverted = ($inverted == true) ? false : true;
        $data = [
            'inverted' => $inverted,
            'activity' => $activity,
        ];
        echo $this->render('/activity/type_' . $activity->type, array_merge($data, json_decode($activity->data, true)));
    }
    ?>
</ul>