<?php

namespace backend\modules\xss;

use backend\modules\BackendModule;

class XssModule extends BackendModule
{
    public $controllerNamespace = 'backend\modules\xss\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
