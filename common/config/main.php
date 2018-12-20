<?php
return [
    'language' => 'ru-RU',
    'bootstrap' => ['telegramHandler'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@imgPath' => dirname(dirname(__DIR__)) . '/common/resources/img',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'telegramHandler' =>[
            'class' => \common\components\telegram\eventHandlers\RegisterHandlers::class
        ],
        'bot' => [
            'class' => \SonkoDmitry\Yii\TelegramBot\Component::class,
            'apiToken' => require dirname(__DIR__) . '/components/telegram/apiToken.php',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => '@app/../common/messages',
                    'sourceLanguage' => 'ru-RU',
                ]
            ]
        ],
        'authManager' => [
            'class' => \yii\rbac\DbManager::class,
        ],
        'assetManager' => [
            'linkAssets' => true,
        ],
    ],
];
