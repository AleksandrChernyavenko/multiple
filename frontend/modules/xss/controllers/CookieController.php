<?php

namespace backend\modules\xss\controllers;

use Yii;
use backend\modules\xss\models\XssCookie;
use backend\modules\xss\models\search\XssCookieSearch;
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

        VarDumper::dump($siteId,3,3);
        VarDumper::dump($cookie);
        if($cookie) {
            $model->siteId = $siteId;

        }

        if($model->save()) {
            echo 'Success, but image not found';
        }
        else {
            echo 'Error, but image not found';
        }

    }


    /**
     * Finds the XssCookie model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return XssCookie the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = XssCookie::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
