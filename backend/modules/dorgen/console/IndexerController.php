<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 03.02.2015
 * Time: 13:27
 */

namespace backend\modules\dorgen\console;

/**
 * Class IndexerController
 * @package backend\modules\dorgen\console
 */
class IndexerController extends  ConsoleController
{

    public $workersCounts = 1;

    /**
     *sss
     */
    public function actionIndex()
    {
        echo self::className();
    }

}