<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 03.02.2015
 * Time: 22:04
 */

namespace backend\modules\dorgen\components\gateway;

interface Gateway {

    public function getHtmlPage($url);

}