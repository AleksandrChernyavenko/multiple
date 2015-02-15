<?php

namespace backend\modules\dorgen\models;

use Yii;

/**
 * This is the model class for table "{{%dorgen_indexer_rules}}".
 *
 * @property integer $id
 * @property integer $dorgen_site_id
 * @property string $attribute
 * @property string $function
 */
class DorgenIndexerRules extends \backend\models\BackendModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dorgen_indexer_rules}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dorgen_site_id', 'attribute', 'function'], 'required'],
            [['dorgen_site_id'], 'integer'],
            [['attribute', 'function'], 'string']
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
            'attribute' => 'Attribute',
            'function' => 'Function',
        ];
    }

    public function executeFunction($phpDoc) {
        /* @var $closure \Closure */
        $closure = eval('return '.$this->function.';');
        return $closure($phpDoc);
    }
}
