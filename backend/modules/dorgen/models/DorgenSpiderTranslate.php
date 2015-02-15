<?php

namespace backend\modules\dorgen\models;

use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "{{%dorgen_spider_translate}}".
 *
 * @property integer $id
 * @property integer $dorgen_crawler_url_id
 * @property integer $dorgen_site_id
 * @property string $status
 * @property string $date_start
 * @property string $date_end
 * @property string $file_name
 * @property string $error_response
 *
 * @property-read string $url
 * @property-read DorgenCrawlerUrls $crawlerUrl
 */
class DorgenSpiderTranslate extends \backend\models\BackendModel
{

    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';
    const STATUS_IN_WORK = 'in_work';

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
            [['dorgen_crawler_url_id', 'status', 'file_name'], 'required'],
            [['id', 'dorgen_crawler_url_id', 'dorgen_site_id'], 'integer'],
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
            'dorgen_site_id' => 'dorgen_site_id',
            'status' => 'Status',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'file_name' => 'File Name',
            'error_response' => 'Error Response',
        ];
    }

    public function getUrl()
    {
        return $this->crawlerUrl->url;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCrawlerUrl()
    {
        return $this->hasOne(DorgenCrawlerUrls::className(),['id'=>'dorgen_crawler_url_id']);
    }

    private $_filesFolderAlias = '@backend/modules/dorgen/components/spider/pages/';

    public function getFileName()
    {
        $folder = \Yii::getAlias($this->_filesFolderAlias);
        //берем первые 9 цыфр id и создаем папки по 3
        $str1 = substr($this->dorgen_crawler_url_id, 0, 3);
        $str2 = substr($this->dorgen_crawler_url_id, 3, 3);
        $str3 = substr($this->dorgen_crawler_url_id, 6, 3);

        $ff = str_pad($str1,3,0)
            .DIRECTORY_SEPARATOR
            .str_pad($str2,3,0)
            .DIRECTORY_SEPARATOR
            .str_pad($str3,3,0)
            .DIRECTORY_SEPARATOR;

        FileHelper::createDirectory($folder.$ff);

       return $ff.$this->dorgen_crawler_url_id;
    }

    public function getFilePath(){
        return  \Yii::getAlias($this->_filesFolderAlias).$this->file_name;
    }

    public function beforeSave($insert)
    {
        $this->dorgen_site_id = $this->dorgen_site_id ? $this->dorgen_site_id : $this->crawlerUrl->dorgen_site_id;
        return parent::beforeSave($insert);
    }


}
