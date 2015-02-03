<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 03.02.2015
 * Time: 22:54
 */

namespace backend\modules\dorgen\components\gateway;

class FileGetContentGateway implements Gateway
{
    public function getHtmlPage($url)
    {
        return file_get_contents($url);
    }

}
