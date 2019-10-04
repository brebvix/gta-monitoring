<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

$this->title = Yii::t('main', 'Игрок') . ' ' . $player->nickname;
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Список игроков'), 'url' => ['/players']];
Yii::$app->params['breadcrumbs'][] = $player->nickname;
Yii::$app->params['description'] = Yii::t('main', 'Игрок {nickname} - список серверов, на которых играл, время на серверах', [
    'nickname' => $player->nickname
]);

?>
<h2 class="text-center"><?= Yii::t('main', 'Поиск игроков') ?></h2>
<?php
$form = ActiveForm::begin();
echo $form->field($formModel, 'nickname')->widget(Select2::classname(), [
    'options' => ['placeholder' => Yii::t('main', 'Поиск игроков ...')],
    'language' => Yii::$app->language,
    'pluginOptions' => [
        'language' => Yii::$app->language,
        'allowClear' => true,
        'minimumInputLength' => 3,
        'ajax' => [
            'url' => \yii\helpers\Url::to(['players-list']),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        'templateResult' => new JsExpression('function(player) {return player.text; }'),
        'templateSelection' => new JsExpression('function (player) {if (player.id !== undefined && player.id.length > 0) {lang = (window.location.pathname.split("/")[1] == "en" ? "/en/" : "/");window.location = lang + "players/" + player.text + "/" + player.id;}return player.text;}'),
    ],
])->label(false);
ActiveForm::end();
?>
<hr>
<div itemscope itemtype="http://schema.org/ProfilePage">
    <div itemprop="mainEntity" itemscope itemtype="http://schema.org/Person">
        <h1 class="text-center"><?= Yii::t('main', 'Игрок') ?> <span itemprop="name"><?= $player->nickname ?></span></h1>
        <div class="pull-left"><?= Yii::t('main', 'Провёл') ?> <?= Yii::$app->formatter->asDuration($player->minutes * 60) ?> <?= Yii::t('main', 'в игре') ?></div>
        <div class="pull-right" data-toggle="tooltip"
             title="<?= $player->date ?>"><?= Yii::t('main', 'Был в игре') ?> <?= Yii::$app->formatter->asRelativeTime($player->date) ?></div>
        <br><br>
        <h4 class="text-center"><?= Yii::t('main', 'Список серверов') ?></h4>
        <br>
        <div style="overflow-x:auto;">
            <table class="table table-clickable table-hover stylish-table">
                <thead>
                <tr>
                    <td><?= Yii::t('main', 'Сервер') ?></td>
                    <td><?= Yii::t('main', 'Время на сервере') ?></td>
                    <td><?= Yii::t('main', 'Последний раз был онлайн') ?></td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($player->relations AS $one):
                    switch ($one->server->game_id) {
                        case 1:
                            $game = 'SAMP';
                            $color = 'success';
                            break;
                        case 2:
                            $game = 'CRMP';
                            $color = 'primary';
                            break;
                        case 3:
                            $game = 'FiveM';
                            $color = 'light-primary';
                            break;
                        case 4:
                            $game = 'MTA';
                            $color = 'light-success';
                            break;
                        case 7:
                            $game = 'RAGE Multiplayer';
                            $color = 'light-warning';
                            break;
                    }
                    ?>
                    <tr>
                        <td>
                            <?= Html::a($one->server->title, ['/server/view', 'id' => $one->server->id, 'title_eng' => $one->server->title_eng, 'game' => $one->server->game()]) ?>
                            <a href="<?= Url::to(['/' . $one->server->game()]) ?>"
                               class="pull-right label label-<?= $color ?>"><?= $game ?></a>
                        </td>
                        <td><?= Yii::$app->formatter->asDuration($one->minutes * 60) ?></td>
                        <td data-toggle="tooltip"
                            title="<?= $one->date ?>"><?= Yii::$app->formatter->asRelativeTime($one->date) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>