<?php

use yii\db\Migration;
use yii\db\Schema;

class m150215_145916_glossary extends Migration
{
    const TABLE = 'glossary';

    public function up()
    {
        $this->createTable(self::TABLE,
            [
                'id' => Schema::TYPE_PK,
                'code' => Schema::TYPE_STRING . '(255) NOT NULL',
                'title' => Schema::TYPE_STRING . '(255) NOT NULL',
                'description' => Schema::TYPE_TEXT .' NOT NULL',
            ]
        );

        $this->createIndex('glossary_code_unique',self::TABLE,'code',true);

    }

    public function down()
    {
        $this->dropTable(self::TABLE);
    }
}
