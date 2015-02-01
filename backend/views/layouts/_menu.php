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
    $menuItems[] = [
        'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
        'url' => ['/site/logout'],
        'linkOptions' => ['data-method' => 'post']
    ];


}

return $menuItems;