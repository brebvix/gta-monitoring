<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Url;

$this->title = $exception->getName();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <title>#<?= isset($exception->statusCode) ? $exception->statusCode : '' ?> <?= $exception->getName() ?> / Servers.Fun</title>
    <!-- Bootstrap Core CSS -->
    <link href="/template_assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="/css/colors/purple.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="fix-header card-no-border logo-center">
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<section id="wrapper" class="error-page">
    <div class="error-box"  style="background-image:url(/images/background/<?= rand(1,19) ?>-min.jpg);-webkit-background-size: cover;background-size: cover;">
        <div class="row" style="">
            <div class="col-4"></div>
            <div class="col-lg-4 col-md-12 col-sm-12 text-center card" style="background-color: rgba(255,255,255,0.85);">
                <div class="error-body text-center">
                    <h1 style="font-size:10em;"><?= isset($exception->statusCode) ? $exception->statusCode : ''  ?></h1>
                    <h3 class="text-uppercase"><?= $exception->getName() ?></h3>
                    <p class="m-t-30 m-b-30" style="color:#455a64;"><?= $exception->getMessage() ?></p>
                    <a href="<?= Url::to(['/']) ?>" class="btn btn-primary btn-rounded waves-effect waves-light m-b-40"><?= Yii::t('main', 'Перейти на главную') ?></a>
                </div>
                <footer class="text-center" style="color:#455a64;">© Gavaga Nazar, 2018-<?= date('Y') ?> | <a href="mailto:servers.fun@gmail.com">servers.fun@gmail.com</a></footer>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
</section>
<script src="/template_assets/plugins/jquery/jquery.min.js"></script>
<script src="/template_assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="/template_assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="/js/waves.js"></script>
</body>
</html>
