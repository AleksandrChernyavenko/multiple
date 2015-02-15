<?php

namespace backend\modules\glossary\models;

use Yii;

/**
 * This is the model class for table "glossary".
 *
 * @property integer $id
 * @property string $code
 * @property string $title
 * @property string $description
 */
class GlossaryModel extends \backend\models\BackendModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'glossary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'title', 'description'], 'required'],
            [['description'], 'string'],
            [['code', 'title'], 'string', 'max' => 255],
            [['code'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'title' => 'Title',
            'description' => 'Description',
        ];
    }
}
