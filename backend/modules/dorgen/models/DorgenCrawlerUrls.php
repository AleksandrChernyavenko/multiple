<?php

namespace backend\modules\dorgen\models;

use Yii;

/**
 * This is the model class for table "{{%dorgen_crawler_urls}}".
 *
 * @property integer $id
 * @property integer $dorgen_site_id
 * @property string $url
 * @property string $status
 * @property integer $is_article
 * @property string $start_time
 * @property string $end_time
 * @property string $error_response
 *
 * @property-read DorgenCrawlerRules $rules
 */
class DorgenCrawlerUrls extends \backend\models\BackendModel
{

    const STATUS_NEW = 'new';
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';
    const STATUS_IN_WORK = 'in_work';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dorgen_crawler_urls}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dorgen_site_id', 'url'], 'required'],
            [['dorgen_site_id', 'is_article'], 'integer'],
            [['status', 'error_response'], 'string'],
            [['start_time', 'end_time'], 'safe'],
            [['url'], 'string', 'max' => 255],
            [['url'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dorgen_site_id' => 'Dorgen Site ID',
            'url' => 'Url',
            'status' => 'Status',
            'is_article' => 'Is Article',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'error_response' => 'Error Response',
        ];
    }

    public function getRules()
    {
        return $this->hasMany(DorgenCrawlerRules::className(),['site_id'=>'dorgen_site_id']);
    }
}
