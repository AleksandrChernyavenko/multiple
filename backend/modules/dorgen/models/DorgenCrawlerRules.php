<?php

namespace backend\modules\dorgen\models;

use Yii;

/**
 * This is the model class for table "{{%dorgen_crawler_rules}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property integer $required
 * @property string $value
 */
class DorgenCrawlerRules extends \backend\models\BackendModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dorgen_crawler_rules}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type', 'value'], 'required'],
            [['type', 'value'], 'string'],
            [['required'], 'integer'],
            [['name'], 'string', 'max' => 255]
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
            'type' => 'Type',
            'required' => 'Required',
            'value' => 'Value',
        ];
    }
}
