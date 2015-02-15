<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 10.02.2015
 * Time: 18:26
 */

namespace backend\modules\dorgen\components;

use backend\modules\dorgen\models\DorgenArticleModel;
use backend\modules\dorgen\models\DorgenIndexer;
use backend\modules\dorgen\models\DorgenSpiderTranslate;
use yii\db\Expression;

class Indexer {


    /**
     * @var \backend\modules\dorgen\models\DorgenIndexer
     */
    public $model;

    /**
     * @var \backend\modules\dorgen\models\DorgenIndexerRules[]
     */
    public $rules;

    public function run() {

        $this->model = $this->getModel();

        try{

            $this->rules = $this->model->rules;

            $article = $this->parseData();

            $dbArticle = DorgenArticleModel::getDb();
            $dbArticle->tablePrefix =  $this->model->dorgenSpiderTranslate->dorgen_site_id.'_';


            $articleModel = new DorgenArticleModel();
            $articleModel->setAttributes($article);
            $articleModel->indexer_id = $this->model->id;
            $articleModel->validate();

            if(!$articleModel->save()) {
                throw new \Exception($articleModel->getErrors());
            };

            $this->saveModel();
            return true;

        }
        catch(\Exception  $e) {
            $this->saveModel($e->getMessage());
            return false;
        }

    }




    private function getModel()
    {
        if($this->model) {
            return $this->model;
        }
        $lastIndexedPage = DorgenIndexer::find()->orderBy(['id'=>SORT_DESC])->one();

        $maxId = $lastIndexedPage ? $lastIndexedPage->id : 0 ;


        $crawlerModel = DorgenSpiderTranslate::find()
            ->where('status = :status',[':status'=>DorgenSpiderTranslate::STATUS_SUCCESS])
            ->andWhere('id > :last_used',[':last_used'=>$maxId])
            ->one();

        $model = new DorgenIndexer();
        $model->status = DorgenIndexer::STATUS_IN_WORK;
        $model->dorgen_spider_translate_id =  $crawlerModel->id;
        $model->start_time =  new Expression('NOW()');


        return  $model->save() ? $model : false;
    }

    private function parseData()
    {
        $phpDoc = $this->getPhpDoc();

        $article = [
        ];

        foreach($this->rules as $rule) {


            $func = 'function($model) {
                    /* @var $model backend\modules\dorgen\models\DorgenCrawlerRules */
                    $site = $model->site;
                    return  $site ? $site->displayName : "";

                }';


            $article[$rule->attribute] = $rule->executeFunction($phpDoc);

        }

        return $article;
    }

    /**
     * @return \phpQueryObject|\QueryTemplatesParse|\QueryTemplatesSource|\QueryTemplatesSourceQuery
     * @throws \Exception
     */
    private function getPhpDoc() {
        $filePath = $this->model->dorgenSpiderTranslate->getFilePath();

        if(!file_exists($filePath)) {
            throw new \Exception('File page translate not exist');
        }

        $phpDoc = \phpQuery::newDocument(file_get_contents($filePath));

        return $phpDoc;

    }

    private function saveModel($errorMessage = false){
        if($errorMessage) {
            $this->model->status = DorgenIndexer::STATUS_ERROR;
            $this->model->error_response = $errorMessage;
        }
        else {
            $this->model->status = DorgenIndexer::STATUS_SUCCESS;
        }

        $this->model->end_time = new Expression('NOW()');
        $this->model->save();
    }

}