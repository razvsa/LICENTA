<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'name'=>'Studio eJobs',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'ckeditor' => [
            'class' => 'dosamigos\ckeditor\CKEditor',
            'editorOptions' => [
                'preset' => 'full',
                'inline' => false,
            ],
        ],
        'modal' => [
            'class' => 'kartik\modal\Module',
        ],
        'bootstrap' => [
            'class' => 'yii\bootstrap\BootstrapAsset',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
            ],
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
        'queue' => [
            'class' => 'yii\queue\file\Queue',
            'as log' => 'yii\queue\LogBehavior',
        ],

    ],
    'params' => $params,
    'controllerMap' => [
        'pusher' => 'frontend\controllers\SiteController'
    ]
];
