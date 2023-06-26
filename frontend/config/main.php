<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'name'=>'eJobs',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute'=>'/site/index',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'GMAILID',
                'password' => 'PASSWORD',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'index' => 'candidat-fisier/categorii'
            ],
        ],
        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'nodes' => [
                [
                    'http_address' => '127.0.0.1:9200',
                    //'auth' => ['username' => 'razvan', 'password' => 'razvan']
                ],
            ],
            'auth' => ['username' => 'razvan', 'password' => 'razvan']
        ],
        'google' => [
            'class' => 'yii\authclient\clients\Google',
            'clientId' => '771207035674-kvglcmgi201cog9bsa9633vvror0utg8.apps.googleusercontent.com',
            'clientSecret' => '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',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            // Other configuration options
        ],
        'pusher' => [
            'class' => 'Pusher\Pusher',
            'appId' => '1603369',
            'appKey' => '2eb047fb81e4d1cc5937',
            'appSecret' => '663cb0d47d32f1d742d5',
            'options' => [
                'cluster' => 'eu',
                'encrypted' => true,
            ],
        ],
        'urlUtility' => [
            'class' => 'app\components\UrlUtility',
        ],


    ],
    'params' => $params,
    'controllerMap' => [
        'pusher' => 'frontend\controllers\SiteController'
    ]
];
