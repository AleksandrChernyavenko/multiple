<?php

use yii\db\Schema;
use yii\db\Migration;

class m150201_174125_xss_sites_table extends Migration
{
    const TABLE_SITES = '{{%xss_sites}}';
    const TABLE_COOKIE = '{{%xss_cookie}}';

    public function up()
    {
        $this->createTable(self::TABLE_SITES,
            [
                'id' => Schema::TYPE_PK,
                'url' => Schema::TYPE_STRING .'(255) NOT NULL',
                'code' => Schema::TYPE_TEXT .' NOT NULL',
            ]
        );

        $this->createIndex('xss_sites_url_uniq',self::TABLE_SITES,'url', true);

        $this->createTable(self::TABLE_COOKIE,
            [
                'id' => Schema::TYPE_PK,
                'sites_id' => Schema::TYPE_INTEGER ,
                'date' => Schema::TYPE_TIMESTAMP .' NOT NULL DEFAULT CURRENT_TIMESTAMP',
                'from_url' => Schema::TYPE_TEXT ,
                'from_ip' => Schema::TYPE_STRING .'(255) NOT NULL',
                'user_agent' => Schema::TYPE_TEXT ,
                'is_mobile' => Schema::TYPE_INTEGER. ' NOT NULL DEFAULT "0"',
                'cookie' => Schema::TYPE_TEXT .' NOT NULL',
            ]
        );
    }

    public function down()
    {
        $this->dropTable(self::TABLE_SITES);
        $this->dropTable(self::TABLE_COOKIE);
    }
}
