<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">

</head>
<body>
<div class="card">
    <div class="card-img">
    <img class="" src="/images/api/1.jpg" alt="Card image cap" >
    </div>
        <div class="card-img-overlay" style="height:110px;">
        <h3 class="card-title text-white m-b-0 dl"><?= $server->title ?></h3>
        <small class="card-text text-white font-light"><a class="text-light" href="<?= Url::to(['/server/view', 'id' => $server->id, 'title_eng' => $server->title_eng, 'game' => $server->game()]) ?>"><?= $server->ip ?>:<?= $server->port ?></a></small>
    </div>
    <div class="card-body weather-small">
        <div class="row" >
            <div class="col-8 b-r align-self-center">
                <div class="d-flex">
                    <div class="display-6 text-info"><i class="mdi mdi-laptop"></i></div>
                    <div class="m-l-20">
                        <h1 class="font-light text-info m-b-0"><?= $server->players ?><sup> / <?= $server->maxplayers ?></sup></h1>
                        <small><?= Yii::t('main', 'Игроки онлайн') ?></small>
                    </div>
                </div>
            </div>
            <div class="col-4 text-center">
                <h1 class="font-light m-b-0"><?= number_format($server->rating, 2, '.', '') ?><sup>/ 10</sup></h1>
                <small><?= Yii::t('main', 'Рейтинг') ?></small>
            </div>
        </div>
    </div>
</div>
</body>
</html>