<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = Yii::t('main', 'Поиск');
Yii::$app->params['breadcrumbs'][] = $this->title;

$this->registerJs("$('.table-clickable tr').on('click', function() {href = $(this).attr('data-href');  if (href.length > 0) { window.location = href;}});", 3);
$this->registerJs("$(document).ready(function() { $('.badge').tooltip();});", 3);

Yii::$app->params['description'] = $this->title . ' ' . Yii::t('main', 'по пользователям и серверам.');
?>
<h1 class="text-center"><?= Yii::t('main', 'Результаты поиска по запросу') ?> <?= $searchText ?></h1>
<?= Html::beginForm(['/site/search'], 'get', ['class' => 'form-horizontal form-material']) ?>
<input type="text" class="form-control m-b-10" name="search"
       placeholder="<?= Yii::t('main', 'Введите название сервера / никнейм пользователя') ?>"
       minlength="3" value="<?= $searchText ?>" required>
<center>
    <button type="submit" class="btn btn-primary"><?= Yii::t('main', 'Поиск') ?></button>
</center>
<?= Html::endForm() ?>
<hr>
<ul class="nav nav-tabs customtab" role="tablist">
    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#servers" role="tab"
                            aria-expanded="true"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span
                    class="hidden-xs-down"><?= Yii::t('main', 'Сервера') ?> <span class="badge badge-primary"><?= count($servers) ?></span></span></a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#players" role="tab" aria-expanded="false"><span
                    class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down"><?= Yii::t('main', 'Игроки') ?> <span
                        class="badge badge-primary"><?= count($players) ?></span></span></a>
    </li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#users" role="tab" aria-expanded="false"><span
                    class="hidden-sm-up"><i class="ti-email"></i></span> <span
                    class="hidden-xs-down"><?= Yii::t('main', 'Пользователи') ?> <span class="badge badge-primary"><?= count($users) ?></span></span></a></li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active" id="servers" role="tabpanel" aria-expanded="true">
        <table class="table table-clickable table-hover stylish-table">
            <thead>
                <tr>
                    <td><?= Yii::t('main', 'Рейтинг') ?></td>
                    <td><?= Yii::t('main', 'Сервер') ?></td>
                    <td><?= Yii::t('main', 'Игроки') ?></td>
                    <td></td>
                </tr>
            </thead>
            <?php foreach ($servers AS $server): ?>
                <?= $this->render('/servers/_server', ['model' => $server]) ?>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="tab-pane" id="players" role="tabpanel" aria-expanded="false">
        <table class="table table-clickable table-hover stylish-table">
            <thead>
            <tr>
                <td><?= Yii::t('main', 'Никнейм') ?></td>
                <td><?= Yii::t('main', 'Время в игре') ?></td>
                <td><?= Yii::t('main', 'Последняя активность') ?></td>
            </tr>
            </thead>
            <?php foreach ($players AS $player): ?>
                <tr>
                    <td>
                        <?= Html::a(
                            $player->nickname,
                            [
                                '/players/view',
                                'id' => $player->id,
                                'nickname_eng' => $player->nickname_eng
                            ]); ?>
                    </td>
                    <td>
                        <?= Yii::$app->formatter->asDuration($player->minutes * 60) ?>
                    </td>
                    <td>
                        <span data-toggle="tooltip" title="<?= $player->date ?>"><?= Yii::$app->formatter->asRelativeTime($player->date) ?></span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="tab-pane" id="users" role="tabpanel" aria-expanded="false">
        <?php foreach ($users AS $user): ?>
            <li class="media">
                    <span class="d-flex mr-3"><img style="width:50px;height:50px;" src="<?= $user->getAvatarLink() ?>"
                                                   alt="User <?= $user->username ?> avatar"></span>
                <a href="<?= Url::to(['/user/profile', 'id' => $user->id]) ?>" class="media-body">
                    <h5 class="text-left mt-0 mb-1">
                        <b><?= $user->username ?></b>
                        <small class="text-muted pull-right">
                            <?= Yii::t('main', 'Зарегистрирован') ?> <?= Yii::$app->formatter->asRelativeTime($user->created_at) ?></small>
                    </h5>
                    <h5 class="m-t-10"><?= Yii::t('main', 'Рейтинг пользователя') ?>
                        <span class="pull-right">
                                        <?= number_format($user->rating, 2, '.', ' ') ?>
                                    </span>
                    </h5>
                    <div class="progress">
                        <div class="progress-bar bg-<?= $user->getRatingColor() ?>"
                             role="progressbar" aria-valuenow="<?= $user->rating * 10 ?>"
                             aria-valuemin="0" aria-valuemax="100"
                             style="width:<?= $user->rating * 10 ?>%; height:6px;"><span
                                    class="sr-only"><?= number_format($user->rating, 2, '.', ' ') ?></span>
                        </div>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>
    </div>
</div>