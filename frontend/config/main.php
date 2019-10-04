<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
$host = explode('.', $_SERVER['HTTP_HOST']);
if (count($host) == 3) {
    $host = $host[1] . '.' . $host[2];
} else {
    $host = $_SERVER['HTTP_HOST'];
}

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'langManager'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'fileCache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'langManager' => [
            'class' => 'app\components\langManager',
        ],
        'i18n' => [
            'translations' => [
                'main' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@frontend/messages',
                ],
                'questions' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@frontend/messages',
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-frontend',
                'httpOnly' => true,
                //'path' => '/',
                //'domain' => ".{$host}",
            ],
        ],
        'session' => [
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'class' => 'cetver\LanguageUrlManager\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'languages' => ['en', 'ru'],
            'rules' => [
                'advertising' => 'advertising/default',
                'login' => 'site/login',
                'signup' => 'site/signup',
                'players' => 'players/index',
                'news/<category>' => 'news/index',
                'news/<category>/<title_eng>/<id:\d+>' => 'news/view',
                'api/<method>/<identifier>' => 'api/get',
                'players/<nickname_eng>/<id:\d+>' => 'players/view',
                '<game>/<title_eng>/<id:\d+>' => 'server/view',
                'go/<identifier>' => 'links/go',
                'news'=>'news',
                'hosting'=>'hosting',
                'telegram'=>'telegram',
                'telegram/<controller>'=>'telegram/<controller>',
                'telegram/<controller>/<action>'=>'telegram/<controller>/<action>',
                'developer'=>'developer',
                'developer/questions/answer-rating'=>'developer/questions/answer-rating',
                'developer/<category>/<child_category>/<title>/<id:\d+>'=>'developer/questions/view',
                'developer/tag/<tag>/'=>'developer/questions/tag',
                'developer/<category>/'=>'developer/questions/category',
                'developer/<controller:\w+>/<action:\w+>'=>'developer/<controller>/<action>',
                'developer/<category>/<child>/'=>'developer/questions/child-category',
                '<action>' => 'servers/<action>',
            ],
            'existsLanguageSubdomain' => false,
            'blacklist' => [],
            'queryParam' => 'language',
            'baseUrl' => '/',
            'scriptUrl' => '/',
            //'scriptUrl' => "//{$host}",
            //'baseUrl' => "//{$host}",
        ],
        'payeer' => [
            'class' => '\yiidreamteam\payeer\Api',
            'accountNumber' => '',
            'apiId' => '',
            'apiSecret' => '',
            'merchantId' => '',
            'merchantSecret' => ''
        ],
        'pm' => [
            'class' => '\yiidreamteam\perfectmoney\Api',
            'accountId' => '',
            'accountPassword' => '',
            'walletNumber' => '',
            'merchantName' => 'Servers.Fun monitoring',
            'alternateSecret' => '',
            'resultUrl' => '/payments/perfect-money/result',
            'successUrl' => '/payments/perfect-money/success',
            'failureUrl' => '/payments/perfect-money/failure',
        ],
        'freeKassa' => [
            'class' => '\yarcode\freekassa\Merchant',
            'merchantId' => '',
            'merchantFormSecret' => '',
            'checkDataSecret' => '',
            'defaultCurrency' => 'DEFAULT_CURRENCY_ID',
            'defaultLanguage' => 'ru' // or 'en'
        ],
    ],
    'modules' => [
        'developer' => [
            'class' => 'frontend\modules\developer\Module',
        ],
        'telegram' => [
            'class' => 'frontend\modules\telegram\Module',
        ],
        'hosting' => [
            'class' => 'frontend\modules\hosting\Module',
        ],
    ],
    'params' => $params,
    'defaultRoute' => 'servers/index',
];
