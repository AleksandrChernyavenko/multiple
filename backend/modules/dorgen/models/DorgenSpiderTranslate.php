<?php

namespace backend\modules\dorgen\models;

use Yii;

/**
 * This is the model class for table "{{%dorgen_spider_translate}}".
 *
 * @property integer $id
 * @property integer $dorgen_crawler_url_id
 * @property string $status
 * @property string $date_start
 * @property string $date_end
 * @property string $file_name
 * @property string $error_response
 */
class DorgenSpiderTranslate extends \backend\models\BackendModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dorgen_spider_translate}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'dorgen_crawler_url_id', 'status', 'file_name'], 'required'],
            [['id', 'dorgen_crawler_url_id'], 'integer'],
            [['status', 'error_response'], 'string'],
            [['date_start', 'date_end'], 'safe'],
            [['file_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dorgen_crawler_url_id' => 'Dorgen Crawler Url ID',
            'status' => 'Status',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'file_name' => 'File Name',
            'error_response' => 'Error Response',
        ];
    }
}
