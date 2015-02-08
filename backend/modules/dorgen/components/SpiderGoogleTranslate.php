<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 05.02.2015
 * Time: 22:08
 */

namespace backend\modules\dorgen\components;

use backend\modules\dorgen\models\DorgenCrawlerUrls;
use backend\modules\dorgen\models\DorgenSpiderTranslate;
use yii\db\Expression;
use yii\helpers\FileHelper;

class SpiderGoogleTranslate{

    public $cookieDirAlias =  '@backend/modules/dorgen/components/spider/cookie';

    private  $UA = array (
        "Mozilla/5.0 (Windows; U; Windows NT 6.0; fr; rv:1.9.1b1) Gecko/20081007 Firefox/3.1b1",
        "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.0",
        "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.19 (KHTML, like Gecko) Chrome/0.4.154.18 Safari/525.19",
        "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.2.149.27 Safari/525.13",
        "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30)",
        "Mozilla/4.0 (compatible; MSIE 7.0b; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.40607)",
        "Mozilla/4.0 (compatible; MSIE 7.0b; Windows NT 5.1; .NET CLR 1.1.4322)",
        "Mozilla/4.0 (compatible; MSIE 7.0b; Windows NT 5.1; .NET CLR 1.0.3705; Media Center PC 3.1; Alexa Toolbar; .NET CLR 1.1.4322; .NET CLR 2.0.50727)",
        "Mozilla/45.0 (compatible; MSIE 6.0; Windows NT 5.1)",
        "Mozilla/4.08 (compatible; MSIE 6.0; Windows NT 5.1)",
        "Mozilla/4.01 (compatible; MSIE 6.0; Windows NT 5.1)");

    private function getRandomUserAgent ( ) {
        return "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36";
        return $this->UA[rand(0,count($this->UA)-1)];
    }

    /**
     * @var \backend\modules\dorgen\models\DorgenSpiderTranslate
     */
    private $model;

    public function run()
    {
       $this->model = $this->getModel();

        try{
            $html = $this->translatePage($this->model->url);
            $file = $this->model->getFilePath();
            file_put_contents($file,$html);
            $this->saveModel();

            return $file;

        }
        catch(\Exception  $e) {
            $this->saveModel($e->getMessage());
            return false;
        }




    }

    /**
     * @return false|\backend\modules\dorgen\models\DorgenCrawlerUrls
     */
    protected function getModel()
    {

        if($this->model) {
            return $this->model;
        }
        $lastSpiderPage = DorgenSpiderTranslate::find()->orderBy(['dorgen_crawler_url_id'=>SORT_DESC])->one();

        $maxId = $lastSpiderPage ? $lastSpiderPage->dorgen_crawler_url_id : 0 ;




        $crawlerModel = DorgenCrawlerUrls::find()
            ->where('status = :status',[':status'=>DorgenCrawlerUrls::STATUS_SUCCESS])
            ->andWhere('is_article = :is_article',[':is_article'=>1])
            ->andWhere('id > :last_used',[':last_used'=>$maxId])
            ->one();

        $model = new DorgenSpiderTranslate();
        $model->status = DorgenSpiderTranslate::STATUS_IN_WORK;
        $model->dorgen_crawler_url_id =  $crawlerModel->id;
        $model->date_start =  new Expression('NOW()');
        $model->file_name = $model->getFileName();

        return $model;

        return  $model->save() ? $model : false;
    }

    protected function saveModel($errorMessage = false){
        if($errorMessage) {
            $this->model->status = DorgenSpiderTranslate::STATUS_ERROR;
            $this->model->error_response = $errorMessage;
        }
        else {
            $this->model->status = DorgenSpiderTranslate::STATUS_SUCCESS;
        }

        $this->model->date_end = new Expression('NOW()');
        $this->model->save();

    }


    private function getCookieDir()
    {
        $dir = \Yii::getAlias($this->cookieDirAlias);

        if(!is_dir($dir))
        {
            FileHelper::createDirectory($dir);
        }

        return $dir;
    }

    private $_cookieFile;

    private function createCookieFile() {
        $this->_cookieFile = $this->getCookieDir() . DIRECTORY_SEPARATOR . time(). rand(1,9999999);
        file_put_contents($this->_cookieFile,'');
        return  $this->_cookieFile;
    }

    private function deleteCookieFile() {
        @unlink($this->_cookieFile);
    }

    private function getCookieFile() {
        return $this->_cookieFile;
    }

    public function translatePage($url) {

        $this->createCookieFile();

        $urlToSteep2  = $this->steep1($url);

        if(!$urlToSteep2) {
            new \Exception('steep1');
        }

        $urlToSteep3  = $this->steep2($urlToSteep2);

        if(!$urlToSteep3) {
            new \Exception('steep2');
        }

        $htmlPage  = $this->steep3($urlToSteep3);

        if(!$htmlPage) {
            new \Exception('steep3');
        }

        $htmlPage  = $this->clearPage($htmlPage);

        $this->deleteCookieFile();

        return $htmlPage;

    }

    private function steep1($url) {

        $url= 'http://translate.google.com.ua/translate?hl=ru&ie=UTF8&prev=_t&sl=auto&tl=ru&u='.$url;
        $referer='http://translate.google.com.ua/';

        $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_USERAGENT, $this->getRandomUserAgent());
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_AUTOREFERER, true);
            curl_setopt($ch, CURLOPT_REFERER, $referer); //откуда пришли
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//разрешить переадресацию
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $output = curl_exec($ch);
        $info = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $info2 = curl_getinfo($ch);
        curl_close($ch);

        if ($output === false || $info != 200) {
            $output = null;
        }

        if($output){

            preg_match_all('/<iframe src="(.*?)" name=c/i', $output, $res);
            $res[1][0] =urldecode($res[1][0]);
            $res = "http://translate.google.com.ua".$res[1][0];
        }
        if(!isset($res))
            return FALSE;

        return $res;
    }

    private function steep2($url) {

        $url = preg_replace('/;/', '&', $url);
        $referer= 'http://translate.google.com.ua/';

        $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_USERAGENT, $this->getRandomUserAgent());
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_AUTOREFERER, true);
            curl_setopt($ch, CURLOPT_REFERER, $referer); //откуда пришли
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//разрешить переадресацию
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

        $output = curl_exec($ch);
        $info = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($output === false || $info != 200) {
            $output = null;
        }

        preg_match_all('/URL=(.*?)">/i', $output, $res);
        $res[1][0] =urldecode($res[1][0]);
        $url = preg_replace('/;/', '&', $res[1][0]);

        return $url;
    }

    private function  steep3($url) {

        $referer= 'http://translate.google.com.ua/';
        $ch = curl_init();
        $url = preg_replace('/;/', '&', $url);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->getRandomUserAgent());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_REFERER, $referer); //откуда пришли
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//разрешить переадресацию
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

//        $cookieFile = Yii::getpathOfAlias('application.components.TranslateCookieGoogle');

//        curl_setopt( $ch, CURLOPT_COOKIEFILE, $cookieFile );

        $output = curl_exec($ch);
        $info = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $info22 = curl_getinfo($ch);


        $infoFull=curl_getinfo($ch);
        $infoUrl=$infoFull['url'];
        curl_close($ch);


        if ($output === false || $info != 200) {
            $output = null;
        }
        if($info != 200)
            return $info;

        return $output;

    }

    private function clearPage($page) {
        $page = preg_replace('/<span class="google-src-text"(.*?)\/span>/', '', $page);
//         $page = preg_replace('/<span class="notranslate"(.*?)span>/', '', $page);
        $page = preg_replace('/<iframe(.*?)iframe>/', '', $page);
        $page = preg_replace('!<script(.*?)</script>!si', '', $page);
        $page = preg_replace('!(lang=ru-x-mtfrom-es)!', '', $page);
        $page = preg_replace('!<span onmouseover="_tipon\(this\)" onmouseout="_tipoff\(\)">(.*?)<\/span>!', "$1", $page);

        $page = preg_replace('!<div align=center id=mega>(.*?)<\/noscript><\/div>!', '', $page);
        $page = preg_replace('!<noscript(.*?)noscript>!', '', $page);
        $page = preg_replace('!http:\/\/translate(.*?)http!', 'http', $page);
        $page = preg_replace('!&amp;usg(.*?)( |>)!', '$2', $page);

        $page = preg_replace('!<style type="text\/css">\.google-src-text(.*?)style>!', '', $page);
        $page = preg_replace('!<meta http-equiv="X-Translated-By" content="Google">!', '', $page);
        $page = preg_replace('!<\!--(.*?)-->!', '', $page);

        $page = preg_replace("!<script(.*?)</script>!si","",$page);
        $page = preg_replace("!notranslate!si","text",$page);
        $page = preg_replace("!onmouseover=!si","",$page);
        $page = preg_replace("!_tipon\(this\)!si","",$page);
        $page = preg_replace("!onmouseout=!si","",$page);
        $page = preg_replace("!_tipoff\(\)!si","",$page);


        return $page;
    }



}