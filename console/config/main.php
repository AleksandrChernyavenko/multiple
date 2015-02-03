<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'console\controllers',
    'modules' => [
        'gii' => 'yii\gii\Module',

        'dorgen' =>[
            'class' => 'backend\modules\dorgen\DorgenModule',
            'controllerMap'=>[
                'crawler' => 'backend\modules\dorgen\console\CrawlerController',
                'spider' => 'backend\modules\dorgen\console\SpiderTranslateController',
                'indexer' => 'backend\modules\dorgen\console\IndexerController',
            ],
        ],
    ],

    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];
