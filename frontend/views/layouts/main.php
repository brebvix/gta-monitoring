<?php

/* @var $this \yii\web\View */

/* @var $content string */

//use rmrevin\yii\ulogin\ULogin;
use yii\helpers\Html;
use frontend\widgets\Banner;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use yii\helpers\Url;
use frontend\widgets\Link;
use yii\helpers\HtmlPurifier;
use common\models\System;

AppAsset::register($this);
$this->registerJsFile('/template_assets/plugins/toast-master/js/jquery.toast.js', ['depends' => 'yii\web\JqueryAsset']);

if (!Yii::$app->user->isGuest) {
    $user = Yii::$app->user->identity;
} else {
    Yii::$app->session->set('lastPage', Yii::$app->request->url);
}

if (isset(Yii::$app->params['description'])) {
    if (isset(Yii::$app->params['main_title'])) {
        $additional = ' / ' . Yii::t('questions', 'Разработка серверов') . ' Servers.Fun';
    } else {
        $additional = ' / Servers.Fun';
    }

    $metaContent = HtmlPurifier::process(Yii::$app->params['description'] . $additional);
} else {
    $metaContent = Yii::t('main', 'Мониторинг SAMP, CRMP, MTA, FiveM, RAGE Multiplayer серверов Servers.Fun: фриланс, статистика, отзывы, web-модули, платные услуги!');
}

$lastNewsCount = \common\models\News::lastNewsCount();
$lastVacanciesCount = \common\models\FreelanceVacancies::lastCount();
$lastServicesCount = \common\models\FreelanceServices::lastCount();
$lastQuestionsCount = \frontend\modules\developer\models\Questions::lastCount();
$freelanceCount = $lastServicesCount + $lastVacanciesCount;
//$serversCount = Servers::find()->count();

$serversCount = System::findOne(['key' => 'servers_count']);
$serversOnline = System::findOne(['key' => 'global_servers_online']);
$playersOnline = System::findOne(['key' => 'global_players_online']);

if (isset(Yii::$app->params['main_title'])) {
    $main_title = Yii::$app->params['main_title'];
} else {
    $main_title = 'Servers.Fun';
}

if (Yii::$app->user->isGuest) {
    if (Yii::$app->language == 'ru-RU' && !Yii::$app->session->get('language', false)) {
        Yii::$app->session->set('language', true);
        $this->registerJs('countries = [\'ru\', \'by\', \'ua\', \'kz\', \'kg\', \'md\', \'ro\', \'tj\', \'uz\'];
        if (countries.indexOf(navigator.language) == -1) {
            $.toast({
                text: "<a href=\"' . Url::to([Yii::$app->request->url . '/', 'language' => 'en']) . '\">Go to english version?</a>",
                position: "bottom-right",
                hideAfter: "10000",
                icon: \'info\',
            });
        }', 3);
    }

//    $this->registerJs("$.toast({
//        text: '" . ULogin::widget([
//            'display' => ULogin::D_PANEL,
//            'fields' => [ULogin::F_EMAIL],
//            'optional' => [ULogin::F_BDATE, ULogin::F_PHOTO_BIG],
//            'providers' => [ULogin::P_VKONTAKTE, ULogin::P_FACEBOOK, ULogin::P_GOOGLE, ULogin::P_INSTAGRAM],
//            'hidden' => [],
//            'redirectUri' => ['site/ulogin'],
//            'forceRedirectUrlScheme' => 'https',
//            'language' => Yii::$app->language == 'ru-RU' ? ULogin::L_RU : ULogin::L_EN,
//            'sortProviders' => ULogin::S_RELEVANT,
//            'verifyEmail' => '1',
//            'mobileButtons' => '0',
//        ]) . "',
//        position: 'bottom-right',
//        loaderBg:'#009efb',
//        bgColor: 'rgba(0,0,0,0.2)',
//        icon: 'info',
//        heading: '" . Yii::t('main', 'Вход на сайт') . "',
//        hideAfter: false,
//        stack: 6
//    });", 3);
}

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language == 'ru-RU' ? 'ru' : 'en' ?>" prefix="og: http://ogp.me/ns#">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> / <?= $main_title ?></title>
    <?php $this->head() ?>
    <meta name="description" content="<?= $metaContent ?>">
    <meta property="og:title" content="<?= $this->title ?>"/>
    <meta property="og:image" content="https://servers.fun/images/logotype600.jpg"/>
    <meta property="og:url" content="<?= Yii::$app->request->absoluteUrl ?>"/>
    <meta property="og:type" content="article"/>
    <meta property="og:description" content="<?= $metaContent ?>"/>
    <meta name="msvalidate.01" content="1C693125C1BE1563CCD6B40841EBE9EA"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link href="/template_assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/template_assets/plugins/toast-master/css/jquery.toast.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/colors/purple.css" id="theme" rel="stylesheet">
    <link href="/template_assets/plugins/footable/css/footable.core.css" rel="stylesheet">
    <link href="/template_assets/plugins/morrisjs/morris.css" rel="stylesheet">
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-9655041313402044",
            enable_page_level_ads: true
        });
    </script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="fix-header card-no-border logo-center" itemscope itemtype="http://schema.org/WebPage">
<?php $this->beginBody() ?>
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
</div>
<div id="main-wrapper">
    <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-light">
            <div class="navbar-collapse">
                <ul class="navbar-nav mr-auto mt-md-0">
                    <!-- This is  -->
                    <li class="nav-item"><a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark"
                                            href="javascript:void(0)"><i class="mdi mdi-menu"></i></a></li>
                    <li class="nav-item hidden-sm-down search-box">
                        <a class="nav-link hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i
                                    class="ti-search"></i> <?= Yii::t('main', 'Поиск') ?></a>

                        <form class="app-search" action="/site/search" method="get" itemprop="potentialAction" itemscope
                              itemtype="http://schema.org/SearchAction">
                            <meta itemprop="target" content="https://servers.fun/site/search?search={search}"/>
                            <input type="text" class="form-control" name="search" itemprop="query-input"
                                   placeholder="<?= Yii::t('main', 'Введите название сервера / никнейм пользователя') ?>"
                                   pattern=".{3,}" title="<?= Yii::t('main', 'Введите минимум 3 символа') ?>" required>
                            <a class="srh-btn"><i class="ti-close"></i></a>
                        </form>
                    </li>
                </ul>
                <ul class="navbar-nav my-lg-0">
                    <?php if (Yii::$app->user->isGuest): ?>
                        <li class="nav-item">
                            <a class="nav-link text-muted text-muted waves-effect waves-dark"
                               href="<?= Url::to(['/site/login']) ?>">
                                <i class="mdi mdi-login-variant"></i> <?= Yii::t('main', 'Войти') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-muted text-muted waves-effect waves-dark"
                               href="<?= Url::to(['/site/signup']) ?>">
                                <i class="mdi mdi-account-plus"></i> <?= Yii::t('main', 'Регистрация') ?>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item dropdown">
                            <?= $this->render('//notifications/list', [
                                'user' => $user
                            ]) ?>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href=""
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                        src="<?= $user->getAvatarLink() ?>" alt="user" class="profile-pic"/>
                                <?= Yii::t('main', 'Профиль') ?></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="<?= $user->getAvatarLink() ?>"
                                                                    alt="user">
                                            </div>
                                            <div class="u-text">
                                                <h4><?= $user->username ?></h4>
                                                <p class="text-muted"><?= $user->about_me ?></p><a
                                                        href="<?= Url::to(['/user/profile', 'id' => $user->id]) ?>"
                                                        class="btn btn-rounded btn-danger btn-sm"><?= Yii::t('main', 'Перейти') ?></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?= Url::to(['/user/balance']) ?>"><i
                                                    class="ti-wallet"></i> <?= Yii::t('main', 'Баланс') ?>
                                            (<?= $user->balance ?><?= Yii::t('main', 'р.') ?>)</a></li>
                                    <li>
                                        <a href="<?= Url::to(['/user/profile', 'id' => $user->id, 'type' => 'message']) ?>"><i
                                                    class="ti-email"></i> <?= Yii::t('main', 'Сообщения') ?></a></li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="<?= Url::to(['/user/profile', 'id' => $user->id, 'type' => 'settings']) ?>"><i
                                                    class="ti-settings"></i> <?= Yii::t('main', 'Настройки') ?></a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?= Url::to(['/site/logout']) ?>"><i
                                                    class="fa fa-power-off"></i> <?= Yii::t('main', 'Выход') ?></a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-muted text-muted waves-effect waves-dark"
                               href="<?= Url::to(['/user/balance']) ?>">
                                <?= number_format($user->balance, 0, '.', ' ') ?> <i class="mdi mdi-currency-rub"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href=""
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i
                                    class="flag-icon flag-icon-<?= Yii::$app->language == 'ru-RU' ? 'ru' : 'us' ?>"></i></a>
                        <div class="dropdown-menu dropdown-menu-right scale-up">
                            <a class="dropdown-item <?= Yii::$app->language == 'ru-RU' ? '' : 'active' ?>"
                               href="<?= Yii::$app->language == 'ru-RU' ? Url::to([Yii::$app->request->url . '/', 'language' => 'en']) : '#' ?>">
                                <i class="flag-icon flag-icon-us"></i>
                                English</a>
                            <a class="dropdown-item <?= Yii::$app->language == 'ru-RU' ? 'active' : '' ?>"
                               href="<?= Yii::$app->language != 'ru-RU' ? Url::to(substr(Yii::$app->request->url, 3)) : '#' ?>"><i
                                        class="flag-icon flag-icon-ru"></i> Русский</a></div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <aside class="left-sidebar">
        <div class="scroll-sidebar">
            <nav class="sidebar-nav" itemscope itemtype="http://schema.org/SiteNavigationElement">
                <ul id="sidebarnav">
                    <li class="two-column">
                        <a class="has-arrow" href="<?= Url::to(['/']) ?>" aria-expanded="false"><i
                                    class="mdi mdi-home"></i><span
                                    class="hide-menu"><?= Yii::t('main', 'Мониторинг') ?></span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li class="text-center" style="width: 100%;"><a href="<?= Url::to(['/']) ?>"><i
                                            class="mdi mdi-view-sequential"></i> <?= Yii::t('main', 'Все сервера') ?>
                                </a></li>
                            <li><a href="<?= Url::to(['/servers/samp']) ?>"
                                   title="San Andreas MultiPlayer, GTA San Andreas"><i class="mdi mdi-gamepad"></i> SAMP</a>
                            </li>
                            <li><a href="<?= Url::to(['/servers/crmp']) ?>"
                                   title="Criminal Russia Multiplayer, GTA San Andreas"><i class="mdi mdi-gamepad"></i>
                                    CRMP</a></li>
                            <li><a href="<?= Url::to(['/servers/mta']) ?>" title="Multi Theft Auto, GTA San Andreas"><i
                                            class="mdi mdi-gamepad"></i> MTA</a></li>
                            <li><a href="<?= Url::to(['/servers/fivem']) ?>" title="FiveM, GTA V"><i
                                            class="mdi mdi-gamepad"></i> FiveM</a></li>
                            <li><a href="<?= Url::to(['/servers/rage-multiplayer']) ?>" title="RAGE Multiplayer, GTA V"><i
                                            class="mdi mdi-gamepad"></i> RAGE Multiplayer</a></li>
                            <?php if (!Yii::$app->user->isGuest): ?>
                                <li><a href="<?= Url::to(['/servers/favorites']) ?>"><i
                                                class="mdi mdi-content-save"></i> <?= Yii::t('main', 'Избранное') ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="mdi mdi-account-switch"></i><span
                                    class="hide-menu"><?= Yii::t('main', 'Фриланс') ?> <?= $freelanceCount > 0 ? '<span class="badge badge-primary">+ ' . $freelanceCount . '</span>' : '' ?></span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="<?= Url::to(['/freelance/vacancies/index']) ?>"><i
                                            class="mdi mdi-account-multiple-outline"></i> <?= Yii::t('main', 'Вакансии') ?> <?= $lastVacanciesCount > 0 ? '<span class="badge badge-primary">+ ' . $lastVacanciesCount . '</span>' : '' ?>
                                </a></li>
                            <li><a href="<?= Url::to(['/freelance/services/index']) ?>"><i
                                            class="mdi mdi-account-multiple"></i> <?= Yii::t('main', 'Услуги') ?> <?= $lastServicesCount > 0 ? '<span class="badge badge-primary">+ ' . $lastServicesCount . '</span>' : '' ?>
                                </a></li>
                        </ul>
                    </li>
                    <li><a href="<?= Url::to(['/developer']) ?>"><i class="mdi mdi-code-braces"></i>
                            <?= Yii::t('main', 'Вопрос-ответ') ?>
                            <?= $lastQuestionsCount > 0 ? '<span class="badge badge-primary">+ ' . $lastQuestionsCount . '</span>' : '' ?>
                        </a></li>
                    <li><a href="<?= Url::to(['/site/activity']) ?>"><i
                                    class="mdi mdi-ticket"></i> <?= Yii::t('main', 'Активность') ?></a></li>
                    <li><a href="<?= Url::to(['/news']) ?>"><i class="mdi mdi-newspaper"></i>
                            <?= Yii::t('main', 'Новости') ?> <?= $lastNewsCount > 0 ? '<span class="badge badge-primary">+ ' . $lastNewsCount . '</span>' : '' ?>
                        </a></li>
                    <li>
                        <a class="has-arrow" href="#" aria-expanded="false"><i class="mdi mdi-help"></i><span
                                    class="hide-menu"><?= Yii::t('main', 'Прочее') ?></span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="<?= Url::to(['/help/api']) ?>"><i
                                            class="mdi mdi-code-tags"></i> API</a></li>
                            <li><a href="<?= Url::to(['/help/telegram-bot']) ?>"><i
                                            class="mdi mdi-telegram"></i> <?= Yii::t('main', 'Telegram бот') ?></a></li>
                            <li><a href="<?= Url::to(['/players']) ?>"><i
                                            class="mdi mdi-gamepad-variant"></i> <?= Yii::t('main', 'Игроки') ?></a></li>
                            <li><a href="<?= Url::to(['/help/faq']) ?>"><i
                                            class="mdi mdi-github-face"></i> FAQ</a></li>
                            <li><a href="<?= Url::to(['/help/rules']) ?>"><i
                                            class="mdi mdi-view-headline"></i> <?= Yii::t('main', 'Правила') ?></a></li>
                            <li><a href="<?= Url::to(['/advertising']) ?>"><i
                                            class="mdi mdi-star-circle"></i> <?= Yii::t('main', 'Реклама') ?></a></li>
                            <li><a href="<?= Url::to(['/help/feedback']) ?>"><i
                                            class="mdi mdi-phone-classic"></i> <?= Yii::t('main', 'Обратная связь') ?>
                                </a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row page-titles">
                <div class="col-md-5 col-8 align-self-center">
                    <h2 class="text-themecolor m-b-0 m-t-0 hidden-md-down"><?= Yii::t('main', 'Игровой') ?> <?= Yii::t('main', 'мониторинг') ?>
                        Servers.Fun</h2>
                    <div itemscope itemtype="http://schema.org/BreadcrumbList">
                        <?= \frontend\widgets\SimpleBreadcrumbWidget::widget([
                            'links' => isset(Yii::$app->params['breadcrumbs']) ? Yii::$app->params['breadcrumbs'] : [],
                            'itemTemplate' => '<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">{link}</li>',
                            'tag' => 'ol',
                            'activeItemTemplate' => '<li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">{link}</li>',
                            'homeLink' => ['label' => Yii::t('main', 'Главная'), 'url' => ['/']],
                        ]) ?>
                    </div>
                </div>
                <div class="col-md-7 col-4 align-self-center">
                    <div class="d-flex m-t-10 justify-content-end">
                        <div class="d-none d-md-none d-xl-block text-center" style="margin-right:5%;">
                            <?= Banner::widget(['id' => 1]) ?>
                        </div>
                        <div class="d-flex m-r-20 m-l-15 hidden-md-down">
                            <div class="chart-text m-r-20" data-toggle="tooltip"
                                 title="<?= Yii::t('main', 'Онлайн серверов') ?> <?= $serversOnline->value; ?> <?= Yii::t('main', 'из') ?> <?= $serversCount->value; ?>">
                                <h6 class="m-b-0">
                                    <small><?= Yii::t('main', 'Серверов') ?></small>
                                </h6>
                                <h4 class="m-t-0 text-info"><?= $serversOnline->value; ?></h4>
                            </div>
                        </div>
                        <div class="d-flex m-r-20 m-l-15 hidden-md-down">
                            <div class="chart-text m-r-20">
                                <h6 class="m-b-0">
                                    <small><?= Yii::t('main', 'Игроков') ?></small>
                                </h6>
                                <h4 class="m-t-0 text-info"><?= $playersOnline->value; ?></h4>
                            </div>
                        </div>
                        <!--
                        <div class="d-flex m-r-40 m-l-20 hidden-md-down">
                            <div class="chart-text m-r-10">
                                <a href="<?= Url::to(['/server/add']) ?>"
                                   class="btn btn-info m-b-20 p-10 btn-block waves-effect waves-light"><i
                                            class="fa fa-plus"></i> <?= Yii::t('main', 'Добавить сервер') ?></a>
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
            <?php
            if (isset(Yii::$app->params['no_layout_card'])):
                echo Alert::widget();
                echo $content;
            else:
                ?>
                <div class="row">
                    <div class="col-lg-8 col-xlg-9 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <?= Alert::widget() ?>
                                <?= $content ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xlg-3 col-md-12 col-sm-12">
                        <div class="row">
                            <div class="card col-12">
                                <div class="card-body">
                                    <div class="list-group">
                                        <a href="<?= Url::to(['/advertising/link/buy']) ?>"
                                           class="list-group-item bg-primary text-light"><i
                                                    class="mdi mdi-currency-rub"></i> <?= Yii::t('main', 'Купить ссылку') ?>
                                        </a>
                                        <?= Link::widget() ?>
                                    </div>
                                </div>
                            </div>

                            <div class="card col-12">
                                <div class="card-body" style="padding-left: 0; padding-right: 0;">
                                    <?= \frontend\widgets\TopServersWidget::widget() ?>
                                </div>
                            </div>

                            <div class="card col-6 col-lg-12 col-xlg-12 col-sm-6">
                                <?= Banner::widget(['id' => 2]) ?>
                            </div>

                            <div class="card col-6 col-lg-12 col-xlg-12 col-sm-6">
                                <?= Banner::widget(['id' => 3]) ?>
                            </div>

                            <div class="card col-6 col-lg-12 col-xlg-12 col-sm-6">
                                <?= Banner::widget(['id' => 4]) ?>
                            </div>

                            <div class="card col-6 col-lg-12 col-xlg-12 col-sm-6">
                                <?= Banner::widget(['id' => 5]) ?>
                            </div>

                            <div class="card col-6 col-lg-12 col-xlg-12 col-sm-6">
                                <?= Banner::widget(['id' => 6]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <footer class="footer">
            <div class="pull-left">
                <script>
                    document.write("<a href='//www.liveinternet.ru/click' " + "target=_blank><img src='//counter.yadro.ru/hit?t11.2;r" + escape(document.referrer) + ((typeof(screen) == "undefined") ? "" : ";s" + screen.width + "*" + screen.height + "*" + (screen.colorDepth ? screen.colorDepth : screen.pixelDepth)) + ";u" + escape(document.URL) + ";h" + escape(document.title.substring(0, 150)) + ";" + Math.random() + "' alt='' title='LiveInternet: показано число просмотров за 24" + " часа, посетителей за 24 часа и за сегодня' " + "border='0' width='88' height='31'><\/a>")
                </script>
            </div>
            © <a href="mailto:servers.fun@gmail.com" target="_blank">Gavaga Nazar</a>, 2018-<?= date('Y') ?>
            <div class="pull-right">
                <a href="https://vk.com/samp" target="_blank"><img alt="Partners group" src="/images/vk_samp.png"></a>
                <a href="//www.free-kassa.ru/" target="_blank"><img alt="Free-Kassa logotype"
                                                                    src="//www.free-kassa.ru/img/fk_btn/13.png"></a>
            </div>
        </footer>
    </div>
</div>
<?php $this->endBody() ?>
<script src="/template_assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="/template_assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="/js/jquery.slimscroll.js"></script>
<script src="/js/waves.js"></script>
<script src="/js/sidebarmenu.js"></script>
<script src="/template_assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="/template_assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="/js/custom.min.js"></script>
<script src="/js/share42.js"></script>
<script src="/template_assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-125105174-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'UA-125105174-1');
</script>
<script>
    var tnSubscribeOptions = {
        serviceWorkerRelativePath: '/tnServiceWorker.js',
        block: '881682'
    };
</script>
</body>
</html>
<?php $this->endPage() ?>
