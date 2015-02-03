<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 03.02.2015
 * Time: 22:12
 */

namespace backend\modules\dorgen\components;

use backend\modules\dorgen\models\DorgenCrawlerUrls;
use yii\db\Expression;
use yii\helpers\VarDumper;

/**
 * Class Crawler
 * @package backend\modules\dorgen\components
 */
class Crawler
{

    /**
     * @var \backend\modules\dorgen\models\DorgenCrawlerUrls
     */
    public $model;

    /**
     * @var \backend\modules\dorgen\models\DorgenCrawlerRules[]
     */
    public $rules;

    /**
     * @var \backend\modules\dorgen\components\gateway\Gateway
     */
    public $gateway;

    /**
     * @param $gatewayClass
     */
    function __construct($gatewayClass = 'backend\modules\dorgen\components\gateway\FileGetContentGateway')
    {
        $this->gateway = new $gatewayClass();
    }

    /**
     * @return bool
     */
    public function run()
    {
        $this->model = $this->getModel();

        if(!$this->model) {
            return false;
        }

        $this->rules = $this->model->rules;

        if(!$this->rules) {
            return false;
        }

        $this->model->start_time = new Expression('NOW()');
        $this->model->status = DorgenCrawlerUrls::STATUS_IN_WORK;
        $this->model->save();


        try {
            $page = $this->gateway->getHtmlPage($this->model->url);

            if($this->isArticle($this->model, $this->rules, $page)) {
                $this->model->is_article = 1;
            }
            $this->model->status = DorgenCrawlerUrls::STATUS_SUCCESS;
            $this->model->end_time = new Expression('NOW()');

            $this->model->save();
        }
        catch(\Exception  $e) {

            $this->model->status = DorgenCrawlerUrls::STATUS_ERROR;
            $this->model->end_time = new Expression('NOW()');
            $this->model->error_response = $e->getMessage();

            $this->model->save();
        }

        try {
            $this->saveLinks($page);
        }
        catch(\Exception  $e) {

            $this->model->status = DorgenCrawlerUrls::STATUS_ERROR;
            $this->model->end_time = new Expression('NOW()');
            $this->model->error_response = $e->getMessage();
            $this->model->save();
        }

    }

    protected function isArticle($model,$rules,$page)
    {
        VarDumper::dump('isArticle',3,3);
        return 1;
    }


    /**
     * @return false|\backend\modules\dorgen\models\DorgenCrawlerUrls
     */
    protected function getModel()
    {
        $model = DorgenCrawlerUrls::findOne('1');
        return  $model ? $model : false;
    }


    /**
     *
     */
    protected function saveLinks($page) {
        VarDumper::dump($this->model,3,3);
        VarDumper::dump($page,3,3);
        exit;
    }

}