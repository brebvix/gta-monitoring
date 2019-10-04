<?php

/* @var $this \yii\web\View */

/* @var $content string */

use rmrevin\yii\ulogin\ULogin;
use yii\widgets\ActiveForm;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use yii\helpers\Url;
use yii\web\View;

$this->title = Yii::t('main', 'Авторизация');

AppAsset::register($this);
$this->registerJsFile('/template_assets/plugins/toast-master/js/jquery.toast.js', ['depends' => 'yii\web\JqueryAsset']);

Yii::$app->params['description'] = $this->title . ' ' . Yii::t('main', '- доступна через все популярные социальные сети!');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= Yii::$app->params['description'] ?> / Servers.Fun">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <title><?= $this->title ?></title>
    <?= $this->head() ?>
    <link href="/template_assets//plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/template_assets/plugins/toast-master/css/jquery.toast.css" rel="stylesheet">
    <link href="/css/colors/blue.css" id="theme" rel="stylesheet">
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<?php $this->beginBody() ?>
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
</div>
<section id="wrapper">
    <div class="login-register login-sidebar" style="background-image:url(/images/background/<?= rand(1,19) ?>-min.jpg);">
        <div class="login-box card" style="background-color: rgba(255,255,255,0.85)">
            <div class="card-body">
                <?= Alert::widget() ?>
                <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['id' => 'loginform', 'class' => 'form-horizontal form-material']]); ?>
                <div class="pull-right">
                    <?php echo ULogin::widget([
                        // widget look'n'feel
                        'display' => ULogin::D_PANEL,

                        // required fields
                        'fields' => [ULogin::F_EMAIL],

                        // optional fields
                        'optional' => [ULogin::F_BDATE, ULogin::F_PHOTO_BIG],

                        // login providers
                        'providers' => [ULogin::P_VKONTAKTE, ULogin::P_FACEBOOK, ULogin::P_STEAM, ULogin::P_GOOGLE, ULogin::P_INSTAGRAM],

                        // login providers that are shown when user clicks on additonal providers button
                        'hidden' => [],

                        // where to should ULogin redirect users after successful login
                        'redirectUri' => ['site/ulogin'],

                        // force use https in redirect uri
                        'forceRedirectUrlScheme' => 'https',

                        // optional params (can be ommited)
                        // force widget language (autodetect by default)
                        'language' => Yii::$app->language == 'ru-RU' ? ULogin::L_RU : ULogin::L_EN,

                        // providers sorting ('relevant' by default)
                        'sortProviders' => ULogin::S_RELEVANT,

                        // verify users' email (disabled by default)
                        'verifyEmail' => '1',

                        // mobile buttons style (enabled by default)
                        'mobileButtons' => '0',
                    ]); ?>
                </div>
                <h3 class="box-title m-b-20"><?= Yii::t('main', 'Авторизация') ?></h3>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <br>
                <?= $form->field($model, 'reCaptcha')->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(false) ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i
                                    class="fa fa-lock m-r-5"></i> <?= Yii::t('main', 'Забыли пароль?') ?></a></div>
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light"
                                type="submit"><?= Yii::t('main', 'Войти') ?>
                        </button>
                    </div>
                </div>
                <div class="form-group m-b-0">
                    <div class="col-sm-12 text-center">
                        <p><?= Yii::t('main', 'Нет аккаунта?') ?> <a href="<?= Url::to(['/site/signup']) ?>"
                                                                     class="text-info m-l-5"><b><?= Yii::t('main', 'Регистрация') ?></b></a>
                        </p>
                    </div>
                </div>
                <?php ActiveForm::end() ?>
                <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form', 'options' => ['id' => 'recoverform', 'class' => 'form-horizontal form-material']]); ?>
                <div class="form-group ">
                    <div class="col-xs-12">
                        <h3><?= Yii::t('main', 'Восстановление пароля') ?></h3>
                        <p class="text-muted"><?= Yii::t('main', 'Введите E-Mail и получите на него инструкции по восстановлению пароля.') ?></p>
                    </div>
                </div>
                <?= $form->field($recoveryModel, 'email')->textInput(['autofocus' => true]) ?>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light"
                                type="submit"><?= Yii::t('main', 'Восстановить') ?>
                        </button>
                    </div>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>

</section>
<?php $this->endBody() ?>
<script src="/template_assets//plugins/bootstrap/js/popper.min.js"></script>
<script src="/template_assets//plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="/js/jquery.slimscroll.js"></script>
<script src="/js/waves.js"></script>
<script src="/js/sidebarmenu.js"></script>
<script src="/template_assets//plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="/template_assets//plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="/js/custom.min.js"></script>
<script src="/template_assets//plugins/styleswitcher/jQuery.style.switcher.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-125105174-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-125105174-1');
</script>
<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter50194489 = new Ya.Metrika2({ id:50194489, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/tag.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks2"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/50194489" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
</body>

</html>
<?php $this->endPage() ?>
