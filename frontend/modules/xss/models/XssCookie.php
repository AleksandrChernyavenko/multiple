<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 01.02.2015
 * Time: 20:06
 */

namespace frontend\modules\xss\models;

use common\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class XssCookie
 * @package frontend\modules\xss\models
 *
 * @property integer $id
 * @property integer $sites_id
 * @property integer $created_at
 * @property string $from_url
 * @property string $from_ip
 * @property string $user_agent
 * @property integer $is_mobile
 * @property string $cookie
 */
class XssCookie extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%xss_cookie}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sites_id', 'is_mobile'], 'integer'],
            [['created_at'], 'safe'],
            [['from_url', 'user_agent', 'cookie'], 'string'],
            [['from_ip', 'cookie'], 'required'],
            [['from_ip'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sites_id' => 'Sites ID',
            'created_at' => 'Created At',
            'from_url' => 'From Url',
            'from_ip' => 'From Ip',
            'user_agent' => 'User Agent',
            'is_mobile' => 'Is Mobile',
            'cookie' => 'Cookie',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'class'=>TimestampBehavior::className(),
        ];
    }
}