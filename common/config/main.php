<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'ru-RU',
    'components' => [
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'defaultTimeZone' => 'Europe/Moscow',
            'timeZone' => 'GMT+3',
            'dateFormat' => 'd MMMM yyyy',
            'datetimeFormat' => 'd-M-Y H:i:s',
            'timeFormat' => 'H:i:s',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'scriptUrl' => 'https://servers.fun',
            'baseUrl' => 'https://servers.fun',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            // ...
        ],
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => '6Ld64mwUAAAAAAKafueKElX77pdYFk4dxQ6ei_IH',
            'secret' => '6Ld64mwUAAAAAEv6ViBeJcYkFRapHyjBcqjkklEo',
        ],
    ],
    'modules' => [
        'markdown' => [
            'class' => 'kartik\markdown\Module',
        ]
    ],
];
