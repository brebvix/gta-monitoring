<?php

use frontend\modules\hosting\models\HostingServers;
use yii\helpers\Url;

$this->registerJsFile('/js/jquery.slimscroll.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJs("$('#serverLog').slimScroll({
        height: '250px',
        start: 'bottom'
    });", 3);
$this->title = Yii::t('main', 'Панель управления сервером');
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Игровой хостинг'), 'url' => Url::to(['/hosting'])];
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Панель управления'), 'url' => Url::to(['/hosting/panel'])];

Yii::$app->params['description'] = Yii::t('main', 'Панель управления игровым сервером');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="row">
                <div class="col-xlg-3 col-lg-3 col-md-3" itemscope itemtype="http://schema.org/SiteNavigationElement">
                    <?= $this->render('/_left') ?>
                </div>
                <div class="col-xlg-9 col-lg-9 col-md-9">
                    <div class="card-body">
                        <h1 class="text-center"><?= Yii::t('main', 'Панель управления сервером') ?></h1>

                        <div class="card text-secondary">
                            <img class="" src="/images/api/1.jpg" style="height: 100px;">
                            <div class="card-img-overlay" style="height:110px;">
                                <h3 class="card-title text-white m-b-0 dl"><?= $server->game->title ?></h3>
                                <span class="label label-<?= $server->status == HostingServers::STATUS_ACTIVE ? 'success' : 'danger' ?> pull-right">
                                <?= Yii::t('main', $server->status == HostingServers::STATUS_ACTIVE ? 'Работает' : 'Не работает') ?>
                            </span>
                            </div>
                            <div class="card-body weather-small">
                                <div class="row">
                                    <div class="col-6 b-r align-self-center">
                                        <div class="d-flex">
                                            <div class="display-6 text-purple"><i
                                                        class="mdi mdi-laptop-chromebook"></i>
                                            </div>
                                            <div class="m-l-20">
                                                <h4 class="font-light text-purple m-b-0">
                                                    <?= $server->location->ip . ':' . $server->port ?>
                                                </h4>
                                                <small><?= Yii::t('main', $server->location->title) ?></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 b-r text-center">
                                        <h3 class="font-light m-b-0" id="slotsTitle"><?= $server->slots ?></h3>
                                        <small><?= Yii::t('main', 'Слотов') ?></small>
                                    </div>
                                    <div class="col-3 text-center">
                                        <h3 class="font-light m-b-0"
                                            id="monthTitle"><?= Yii::$app->formatter->asRelativeTime($server->end_date) ?> </h3>
                                        <small><?= Yii::t('main', 'Окончание') ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                                <div class="card">
                                    <div class="card-body bg-purple">
                                        <h4 class="text-white card-title"><?= Yii::t('main', 'Управление сервером') ?></h4>
                                        <h6 class="card-subtitle text-white m-b-0 op-5">
                                            <?= Yii::t('main', 'Управление основными функциями сервера') ?>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="message-box contact-box">
                                            <div class="message-widget contact-widget">
                                                <a href="<?= Url::to(['/hosting/panel/start', 'server_id' => $server->id]) ?>">
                                                    <div class="user-img"><span class="round bg-success"><i
                                                                    class="mdi mdi-play"></i></span><span
                                                                class="profile-status online pull-right"></span></div>
                                                    <div class="mail-contnet">
                                                        <h5><?= Yii::t('main', 'Запуск сервера') ?></h5>
                                                        <span class="mail-desc"><?= Yii::t('main', 'Запускает сервер, если уже запущен - будет перезапущен') ?></span>
                                                    </div>
                                                </a>
                                                <a href="<?= Url::to(['/hosting/panel/stop', 'server_id' => $server->id]) ?>">
                                                    <div class="user-img"><span class="round bg-danger"><i
                                                                    class="mdi mdi-stop"></i></span> <span
                                                                class="profile-status busy pull-right"></span></div>
                                                    <div class="mail-contnet">
                                                        <h5><?= Yii::t('main', 'Остановка сервера') ?></h5>
                                                        <span class="mail-desc"><?= Yii::t('main', 'Мгновенно останавливает сервер') ?></span>
                                                    </div>
                                                </a>
                                                <a href="<?= Url::to(['/hosting/panel/restart', 'server_id' => $server->id]) ?>">
                                                    <div class="user-img"><span class="round bg-warning"><i
                                                                    class="mdi mdi-restart"></i></span> <span
                                                                class="profile-status away pull-right"></span></div>
                                                    <div class="mail-contnet">
                                                        <h5><?= Yii::t('main', 'Перезагрузка сервера') ?></h5>
                                                        <span class="mail-desc"><?= Yii::t('main', 'Останавливает сервер и сразу же его запускает') ?></span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row text-center">
                                                    <div class="col-12">
                                                        <h3><?= $server->cpu_load ?>%</h3>
                                                        <h6 class="card-subtitle">CPU</h6></div>
                                                    <div class="col-12">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                 style="width: <?= $server->cpu_load ?>%; height: 6px;"
                                                                 aria-valuenow="<?= $server->cpu_load ?>"
                                                                 aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row text-center">
                                                    <div class="col-12">
                                                        <h3><?= $server->ram_load ?>%</h3>
                                                        <h6 class="card-subtitle">RAM</h6></div>
                                                    <div class="col-12">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-info" role="progressbar"
                                                                 style="width: <?= $server->ram_load ?>%; height: 6px;"
                                                                 aria-valuenow="<?= $server->ram_load ?>"
                                                                 aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12">
                                        <a href="#" class="card" data-toggle="modal" data-target="#ftpModal">
                                            <div class="d-flex flex-row">
                                                <div class="p-10 bg-purple">
                                                    <h3 class="text-white box m-b-0"><i class="mdi mdi-server"></i></h3>
                                                </div>
                                                <div class="align-self-center m-l-20">
                                                    <h3 class="m-b-0 text-purple"><?= $server->location->ip ?></h3>
                                                    <h5 class="text-muted m-b-0"><?= Yii::t('main', 'Доступы к') ?>
                                                        FTP</h5>
                                                </div>
                                            </div>
                                        </a>
                                        <div id="ftpModal" class="modal fade" tabindex="-1" role="dialog"
                                             aria-labelledby="ftpModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="ftpModalLabel">
                                                            FTP <?= Yii::t('main', 'доступы к файлам сервера') ?></h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-hidden="true">×
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>
                                                            <?= Yii::t('main', 'Для доступа Вы можете использовать любой FTP клиент (один из вариантов') ?>
                                                            -
                                                            <a href="https://filezilla-project.org/download.php?type=client">
                                                                FileZilla
                                                            </a>).
                                                        </p>
                                                        <ul>
                                                            <li><?= Yii::t('main', 'Адрес сервера') ?>:
                                                                <b><?= $server->location->ip ?></b></li>
                                                            <li><?= Yii::t('main', 'Имя пользователя') ?>:
                                                                <b>fun<?= $server->id ?></b></li>
                                                            <li><?= Yii::t('main', 'Пароль') ?>:
                                                                <b><?= $server->ftp_password ?></b></li>
                                                        </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary waves-effect"
                                                                data-dismiss="modal"><?= Yii::t('main', 'Закрыть') ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12">
                                        <a href="#" class="card" data-toggle="modal" data-target="#mysqlModal">
                                            <div class="d-flex flex-row">
                                                <div class="p-10 bg-purple">
                                                    <h3 class="text-white box m-b-0"><i class="mdi mdi-database"></i>
                                                    </h3>
                                                </div>
                                                <div class="align-self-center m-l-20">
                                                    <h3 class="m-b-0 text-purple"><?= $server->location->ip ?></h3>
                                                    <h5 class="text-muted m-b-0"><?= Yii::t('main', 'Доступы к') ?>
                                                        MySQL</h5></div>
                                            </div>
                                        </a>
                                        <div id="mysqlModal" class="modal fade" tabindex="-1" role="dialog"
                                             aria-labelledby="ftpModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="ftpModalLabel">
                                                            <?= Yii::t('main', 'Доступы к базе данных') ?>
                                                        </h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-hidden="true">×
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>
                                                            <?= Yii::t('main', 'Для использования базы данных перейдите в PHPMyAdmin по ссылке ниже.') ?>
                                                        </p>
                                                        <ul>
                                                            <li><?= Yii::t('main', 'Адрес') ?> PHPMyAdmin: <a
                                                                        href="http://<?= $server->location->ip ?>/phpmyadmin"
                                                                        target="_blank">http://<?= $server->location->ip ?>
                                                                    /phpmyadmin</a></li>
                                                            <li><?= Yii::t('main', 'Название базы данных') ?>:
                                                                <b>dbfun<?= $server->id ?></b></li>
                                                            <li><?= Yii::t('main', 'Имя пользователя') ?>:
                                                                <b>fun<?= $server->id ?></b></li>
                                                            <li><?= Yii::t('main', 'Пароль') ?>:
                                                                <b><?= $server->database_password ?></b></li>
                                                        </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary waves-effect"
                                                                data-dismiss="modal"><?= Yii::t('main', 'Закрыть') ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h3 class="text-center text-muted"><?= Yii::t('main', 'Логи сервера') ?></h3>
                        <div id="serverLog"><?= $serverLog ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>