<?php

namespace backend\modules\dorgen\models;

use Yii;

/**
 * This is the model class for table "{{%dorgen_crawler_rules}}".
 *
 * @property integer $id
 * @property integer $site_id
 * @property string $name
 * @property string $type
 * @property integer $required
 * @property string $value
 *
 * @property-read \backend\modules\dorgen\models\DorgenSites $site
 */
class DorgenCrawlerRules extends \backend\models\BackendModel
{

    const TYPE_URL_REGEX = 'url_regex';
    const TYPE_HTML_REGEX = 'html_regex';

    const REG_EX_TAG = '~';

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
            [['name', 'type', 'value', 'site_id'], 'required'],
            [['type', 'value'], 'string'],
            [['required','site_id'], 'integer'],
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
            'site_id' => 'site_id',
            'name' => 'Name',
            'type' => 'Type',
            'required' => 'Required',
            'value' => 'Value',
        ];
    }

    public function isArticle($url,$page) {
        if($this->type == self::TYPE_URL_REGEX) {
            $subject  = $url;
        }
        elseif($this->type == self::TYPE_HTML_REGEX) {
            $subject  = $page;
        }

        $pattern = self::REG_EX_TAG.$this->value.self::REG_EX_TAG;
        return preg_match($pattern,$subject);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSite()
    {
        return $this->hasOne(DorgenSites::className(),['id'=>'site_id']);
    }
}
