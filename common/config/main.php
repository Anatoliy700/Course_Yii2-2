<?php
return [
    //'language' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@imgPath' => dirname(dirname(__DIR__)) . '/common/images',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
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
