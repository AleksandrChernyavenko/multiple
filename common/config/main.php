<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\MemCache',
        ],

        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules'=>[
                '<controller:\w+>/<action:\w+>/<id:\d+>'        => '<controller>/<action>',
                '/<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'        => '/<module>/<controller>/<action>',
            ]
        ],

    ],
];
