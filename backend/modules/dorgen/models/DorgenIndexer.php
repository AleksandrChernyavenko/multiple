<?php

namespace backend\modules\dorgen\models;

use Yii;

/**
 * This is the model class for table "{{%dorgen_indexer}}".
 *
 * @property integer $id
 * @property integer $dorgen_spider_translate_id
 * @property string $status
 * @property string $start_time
 * @property string $end_time
 * @property string $error_response
 */
class DorgenIndexer extends \backend\models\BackendModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dorgen_indexer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dorgen_spider_translate_id', 'status'], 'required'],
            [['dorgen_spider_translate_id'], 'integer'],
            [['status', 'error_response'], 'string'],
            [['start_time', 'end_time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dorgen_spider_translate_id' => 'Dorgen Spider Translate ID',
            'status' => 'Status',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'error_response' => 'Error Response',
        ];
    }
}
