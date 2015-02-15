<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 01.02.2015
 * Time: 22:19
 */

$menuItems = [
    ['label' => 'Home', 'url' => ['/site/index']],
];
if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
} else {
    //xss
    $menuItems[] = [
        'label' => 'Xss',
        'items'=>[
            [
                'label' => 'Xss_Sites',
                'url' => ['/xss/sites/index'],
            ],
            [
                'label' => 'Xss_Cookie',
                'url' => ['/xss/cookie/index'],
            ]
        ]
    ];
    //dorgen
    $menuItems[] = [
        'label' => 'Дорвеи',
        'items'=>[
            [
                'label' => 'Сайты',
                'url' => ['/dorgen/dorgen-sites/index'],
            ],
            [
                'label' => 'CrawlerRules',
                'url' => ['/dorgen/dorgen-crawler-rules/index'],
            ],
            [
                'label' => 'IndexerRules',
                'url' => ['/dorgen/dorgen-indexer-rules/index'],
            ],
            [
                'label' => 'CrawlerUrls',
                'url' => ['/dorgen/dorgen-crawler-urls/index'],
            ],
            [
                'label' => 'SpiderTranslate',
                'url' => ['/dorgen/dorgen-spider-translate/index'],
            ],
            [
                'label' => 'Indexer',
                'url' => ['/dorgen/dorgen-indexer/index'],
            ],
        ]
    ];

    $menuItems[] = [
        'label' => 'Инструмены',
        'items'=>[
            [
                'label' => 'Глоссарий',
                'url' => ['/glossary/glossary/index'],
            ],
        ]
    ];

    $menuItems[] = [
        'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
        'url' => ['/site/logout'],
        'linkOptions' => ['data-method' => 'post']
    ];


}

return $menuItems;