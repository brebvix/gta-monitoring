<?php

/* @var $this \yii\web\View */

/* @var $content string */

use rmrevin\yii\ulogin\ULogin;
use yii\widgets\ActiveForm;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use yii\helpers\Url;

$this->title = Yii::t('main', 'Регистрация');

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
    <link href="/css/colors/blue.css" id="theme" rel="stylesheet">
    <link href="/template_assets/plugins/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
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
                <?php $form = ActiveForm::begin(['id' => 'form-signup', 'options' => ['id' => 'loginform', 'class' => 'form-horizontal form-material']]); ?>
                <div class="pull-right">
                    <?= ULogin::widget([
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
                <h3 class="box-title m-b-20"><?= Yii::t('main', 'Регистрация') ?></h3>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rePassword')->passwordInput() ?>
                <br>
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="checkbox checkbox-success p-t-0 p-l-10">
                            <input id="checkbox-signup" type="checkbox">
                            <label for="checkbox-signup"> <?= Yii::t('main', 'Я принимаю') ?> <a
                                        data-toggle="modal" data-target="#rules-modal" href="#"><?= Yii::t('main', 'правила') ?></a></label>
                        </div>
                    </div>
                </div>
                <br>
                <?= $form->field($model, 'reCaptcha')->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(false) ?>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light"
                                type="submit"><?= Yii::t('main', 'Регистрация') ?>
                        </button>
                    </div>
                </div>
                <div class="form-group m-b-0">
                    <div class="col-sm-12 text-center">
                        <p><?= Yii::t('main', 'Уже есть аккаунт?') ?> <a href="<?= Url::to(['/site/login']) ?>"
                                                                         class="text-info m-l-5"><b><?= Yii::t('main', 'Авторизация') ?></b></a>
                        </p>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

</section>

<div id="rules-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel"><?= Yii::t('main', 'Правила сайта') ?> Servers.Fun</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <?= $this->render('/rules/main') ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><?= Yii::t('main', 'Закрыть') ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
<script src="/template_assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
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
