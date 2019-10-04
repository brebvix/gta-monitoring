<?php
use yii\helpers\Url;

?>
<div class="card-body inbox-panel">

    <a href="<?= Url::to(['/hosting/order']) ?>"
       class="btn btn-danger m-b-20 p-10 btn-block waves-effect waves-light"><?= Yii::t('main', 'Заказать сервер') ?></a>
    <?php if (!Yii::$app->user->isGuest): ?>
        <a href="<?= Url::to(['/hosting/panel']) ?>"
           class="btn btn-primary m-b-20 p-10 btn-block waves-effect waves-light"><?= Yii::t('main', 'Панель управления') ?></a>
    <?php endif; ?>
    <center>
        <a href="mailto:support@servers.fun" class="text-muted">support@servers.fun</a>
    </center>
</div>
<div class="m-3">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h3>99.5</h3>
                    <h6 class="card-subtitle">UpTime</h6></div>
                <div class="col-12">
                    <div class="progress">
                        <div class="progress-bar bg-inverse" role="progressbar"
                             style="width: 99.5%; height: 6px;" aria-valuenow="99.5"
                             aria-valuemin="0"
                             aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="m-3">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h3>6%</h3>
                    <h6 class="card-subtitle"><?= Yii::t('main', 'Средняя нагрузка') ?> CPU</h6></div>
                <div class="col-12">
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar"
                             style="width: 6%; height: 6px;" aria-valuenow="6" aria-valuemin="0"
                             aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="m-3">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h3>15%</h3>
                    <h6 class="card-subtitle"><?= Yii::t('main', 'Средняя нагрузка') ?> RAM</h6></div>
                <div class="col-12">
                    <div class="progress">
                        <div class="progress-bar bg-info" role="progressbar"
                             style="width: 15%; height: 6px;" aria-valuenow="15"
                             aria-valuemin="0"
                             aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="m-3">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h3>32 ms</h3>
                    <h6 class="card-subtitle"><?= Yii::t('main', 'Средний пинг') ?></h6></div>
                <div class="col-12">
                    <div class="progress">
                        <div class="progress-bar bg-danger" role="progressbar"
                             style="width: 32%; height: 6px;" aria-valuenow="32"
                             aria-valuemin="0"
                             aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="m-3">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h3>20 <?= Yii::t('main', 'минут') ?></h3>
                    <h6 class="card-subtitle"><?= Yii::t('main', 'Время ответа поддержки') ?></h6></div>
                <div class="col-12">
                    <div class="progress">
                        <div class="progress-bar bg-primary" role="progressbar"
                             style="width: 20%; height: 6px;" aria-valuenow="20"
                             aria-valuemin="0"
                             aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>