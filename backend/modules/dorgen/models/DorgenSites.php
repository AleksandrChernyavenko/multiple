<?php

namespace backend\modules\dorgen\models;

use Yii;

/**
 * This is the model class for table "{{%dorgen_sites}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $description
 * @property string $status
 * @property string $host
 */
class DorgenSites extends \backend\models\BackendModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dorgen_sites}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'description', 'host'], 'required'],
            [['status'], 'string'],
            [['name', 'url', 'description', 'host'], 'string', 'max' => 255],
            [['url'], 'unique'],
            [['url'], 'url'],
            [['host'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'url' => 'Url',
            'description' => 'Description',
            'status' => 'Status',
            'host' => 'Host',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($insert) {
            $this->createTablesForDorgen();
        }
        parent::afterSave($insert, $changedAttributes);
    }


    private function createTablesForDorgen() {
        /** @var  \yii\db\Connection $db */
        $db = Yii::$app->getDb();
        /** @var  \yii\db\Connection $dbDorvei */
        $dbDorvei = Yii::$app->get('dbDorvei');


        $dbName  = explode('=',$db->dsn);
        $dbName = $dbName[2];

        $dbDorveiName  = explode('=',$dbDorvei->dsn);
        $dbDorveiName = $dbDorveiName[2];
        $id = $this->id;

        $sqlArticle = <<<SQL
CREATE TABLE IF NOT EXISTS `{$dbDorveiName}`.`{$id}_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `indexer_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `prev_img` varchar(255) DEFAULT NULL,
  `prev_content` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
);
SQL;
;


        $sqlSettings = <<<SQL
DROP TABLE IF EXISTS `{$dbDorveiName}`.`{$id}_settings`;

CREATE  TABLE  `{$dbDorveiName}`.`{$id}_settings` (
 `name` varchar( 255  )  NOT  NULL ,
 `value` text,
 PRIMARY  KEY (  `name`  )
 );

SET SQL_MODE =  'NO_AUTO_VALUE_ON_ZERO';

INSERT INTO  `{$dbDorveiName}`.`{$id}_settings` SELECT * FROM  `{$dbName}`.`dorgen_sites_settings` ;
SQL;

       $db->createCommand($sqlArticle)->execute();
       $db->createCommand($sqlSettings)->execute();

    }



}
