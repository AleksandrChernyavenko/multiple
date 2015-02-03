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
}
