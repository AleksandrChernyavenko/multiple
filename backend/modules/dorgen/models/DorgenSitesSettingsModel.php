<?php

namespace backend\modules\dorgen\models;

use Yii;

/**
 * This is the model class for table "dorgen_sites_settings".
 *
 * @property string $name
 * @property string $value
 */
class DorgenSitesSettingsModel extends \backend\models\BackendModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dorgen_sites_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['value'], 'string'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'value' => 'Value',
        ];
    }
}
