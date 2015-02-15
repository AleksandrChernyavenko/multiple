<?php

namespace backend\modules\dorgen\models;

use Yii;

/**
 * This is the model class for table "{{%dorgen_article}}".
 *
 * @property integer $id
 * @property integer $indexer_id
 * @property string $title
 * @property string $prev_img
 * @property string $content
 */
class DorgenArticleModel extends \backend\models\BackendModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    public static function getDb()
    {
        return Yii::$app->get('dbDorvei');
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['indexer_id', 'title', 'content'], 'required'],
            [['indexer_id'], 'integer'],
            [['content'], 'string'],
            [['title', 'prev_img'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'indexer_id' => 'Indexer ID',
            'title' => 'Title',
            'prev_img' => 'Prev Img',
            'content' => 'Content',
        ];
    }
}
