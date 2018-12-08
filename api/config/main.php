<?php
return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableSession' => false,
            'enableAutoLogin' => false,
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
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<module:(v1)>/tasks/<action:[\w-]+>/<id:\d+>' => '<module>/task/<action>',
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/task']],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/project']],
            ],
        ],
    ],
    'modules' => [
        'v1' => [
            'class' => \api\modules\v1\Module::class
        ],
    ]
];