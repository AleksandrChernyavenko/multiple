<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 15.02.2015
 * Time: 14:57
 */

namespace backend\modules\glossary\helpers;

use yii\helpers\Html;
use yii\helpers\Url;

class Popover {

    public static function g($code){

        $options = [
            'data-ajaxload'=>Url::to(['/glossary/glossary/get','code'=>$code],true),
            'data-toggle'=>'glossary-popover',
            'class'=>'glossary-popover glyphicon glyphicon-question-sign',
        ];

        return Html::tag('span','',$options);
    }

}