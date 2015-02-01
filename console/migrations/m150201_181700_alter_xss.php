<?php

use yii\db\Schema;
use yii\db\Migration;

class m150201_181700_alter_xss extends Migration
{
    const TABLE_COOKIE = '{{%xss_cookie}}';
    const OLD_NAME = 'date';
    const NEW_NAME = 'created_at';

    public function up()
    {

        $this->renameColumn(self::TABLE_COOKIE,self::OLD_NAME,self::NEW_NAME);
    }

    public function down()
    {
        $this->renameColumn(self::TABLE_COOKIE,self::NEW_NAME,self::OLD_NAME);
    }
}
