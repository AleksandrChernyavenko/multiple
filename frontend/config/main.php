<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
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
            'errorAction' => 'site/empty-error',
        ],

        'urlManager' => [
            'rules'=>[
                //need for xss cookie
                "c/<siteId:\d+>/<cookie:(.*)+>" => "/xss/cookie/create",
                "c/<cookie:[\w|\-]+>" => "/xss/cookie/create",
                //need for xss cookie
            ]
        ],

    ],

    'modules'=> [
        'xss'=> [
            'class'=>'frontend\modules\xss\XssModule'
        ],
    ],

    'params' => $params,
];
