<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 03.02.2015
 * Time: 13:27
 */

namespace backend\modules\dorgen\console;
use backend\modules\dorgen\components\Crawler;
use yii\helpers\Console;

/**
 * Class TestController
 * @package backend\modules\dorgen\console
 */
class CrawlerController extends  ConsoleController
{

    public $workersCounts = 2;

    public function actionIndex()
    {
        $this->stdout(PHP_EOL.'Start'.PHP_EOL, Console::FG_GREEN, Console::UNDERLINE);
        $this->startWork();
        $this->stdout('Done', Console::FG_GREEN, Console::UNDERLINE);
        echo PHP_EOL;

    }

    public $usleep = 500000; // 5000000 = 5 сек
    public $workSecond = 60;

    private $_start;

    public function startWork() {

        $this->_start = time();

        while($this->_start > (time()-$this->workSecond)) {
            $this->stdout((time()-$this->workSecond), Console::FG_RED, Console::UNDERLINE);
            echo PHP_EOL;
            $this->runCrawler();
            usleep($this->usleep);
        }

    }

    public function runCrawler()
    {
        $crawler = new Crawler();
        $crawler->run();
    }

}