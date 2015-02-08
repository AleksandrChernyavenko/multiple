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

        $this->model->start_time = new Expression('NOW()');
        $this->model->status = DorgenCrawlerUrls::STATUS_IN_WORK;
        $this->model->save();

        $this->rules = $this->model->rules;

        if(!$this->rules) {
            return false;
        }


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
        $isArticle = null;

        foreach($rules as $rule) {

            if($rule->required) {
                //если правило обязательно и другое оязательное правило не вывявило $isArticle=false
                $setArticle = is_null($isArticle) ? true : $isArticle;
                $isArticle = $setArticle && $rule->isArticle($model->url,$page);
            }
            elseif(is_null($isArticle) && $rule->isArticle($model->url,$page)){
                $isArticle = true;
            }

        }

        return  (bool)$isArticle;
    }


    /**
     * @return false|\backend\modules\dorgen\models\DorgenCrawlerUrls
     */
    protected function getModel()
    {
        $model = DorgenCrawlerUrls::findOne(['status'=>DorgenCrawlerUrls::STATUS_NEW]);
        return  $model ? $model : false;
    }


    /**
     *
     */
    protected function saveLinks($page) {

        $links = $this->getLinks($page);

        if(empty($links)) {
            return 0;
        }

        $links = $this->normalizeLinks($links, $this->model->site->url);



        foreach($links as $link)
        {
            $model = new DorgenCrawlerUrls();
            $model->url = $link;
            $model->dorgen_site_id =   $this->model->dorgen_site_id;
            $model->save();
        }



    }

    protected function getLinks($page)
    {
        $page = \phpQuery::newDocumentHTML($page);

        $links = [];

        foreach( $page->find('a') as $link)
        {
            $link = pq($link)->attr('href');
            $links[$link] = $link;
        }
        return $links;
    }

    protected function normalizeLinks($links, $canonicalUrl)
    {
        foreach($links as $index=>&$link) {

            if(strpos($link,'http') !== 0) { //добавляем в url host ,если у нас относительная ссылка

                $link = $canonicalUrl.$link;
                //удаляем сдвоенные слкеши кроме тех что идут в http://
                $link = preg_replace('~(?<!:)//~','/',$link);
            }

            //удаляем ссылки на другие ресурсы
            if(strpos($link,$canonicalUrl) !== 0) {
                unset($links[$index]);
            }

            //удаляем "#" из ссылки
            if(strpos($link,'#') !== false) {
                $link = substr($link, 0, strpos($link,'#'));
            }

        }
        return $links;

    }

}