<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 01.02.2015
 * Time: 20:02
 */

namespace backend\modules;

use yii\base\Module;
use yii\web\ForbiddenHttpException;

class BackendModule extends Module
{
    public function beforeAction($action)
    {
        if(\Yii::$app->has('user') && \Yii::$app->getUser()->isGuest) {
            throw new ForbiddenHttpException;
        }
        return parent::beforeAction($action);
    }

}