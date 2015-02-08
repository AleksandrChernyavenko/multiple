<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 03.02.2015
 * Time: 20:49
 */

namespace backend\modules\dorgen\console;

use yii\console\Controller;
use yii\helpers\Console;
use yii\helpers\FileHelper;

/**
 * Class ConsoleController
 * @package backend\modules\dorgen\console
 */
class ConsoleController extends Controller
{
    public $workersCounts = 1;

    private $pidDirAlias = '@backend/modules/dorgen/console/pid/';

    const STOP_FILE = 'stop.lock';


    public function beforeAction($action)
    {
        if(!$this->canRun()) {
            $this->stdout(PHP_EOL.'Can\'t run'.PHP_EOL.PHP_EOL, Console::FG_RED, Console::UNDERLINE);
            exit(0);
        }

        $this->createLockFile();
        register_shutdown_function(array($this, 'registerShutdownFunction')); // the & is important

        return parent::beforeAction($action);
    }

    private function canRun()
    {
        if($this->isStop()) {
            return false;
        }


        $processCount = $this->getProcessCount();


        if($processCount >= $this->workersCounts) {
            return false;
        }
        else {
            return true;
        }
    }

    private function isStop()
    {
        return file_exists(\Yii::getAlias($this->pidDirAlias).self::STOP_FILE);
    }


    private function getProcessCount()
    {
        $pidDir = $this->getPidDir();
        return (int)(count(scandir($pidDir)) - 2);
    }

    private function getPidDir()
    {
        $dir = \Yii::getAlias($this->pidDirAlias).$this->getShortName();

        if(!is_dir($dir))
        {
            FileHelper::createDirectory($dir);
        }

        return $dir;
    }

    public function registerShutdownFunction()
    {
        $pid = getmypid();
        $dir = $this->getPidDir().DIRECTORY_SEPARATOR.$pid;
        @unlink($dir);
    }


    private function getShortName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }

    private function createLockFile()
    {
        $pid = getmypid();
        $dir = $this->getPidDir().DIRECTORY_SEPARATOR.$pid;
        return file_put_contents($dir,$pid);
    }

    function __destruct()
    {
        $this->registerShutdownFunction();
    }


}