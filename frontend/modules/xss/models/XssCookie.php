<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 01.02.2015
 * Time: 20:06
 */

namespace backend\modules\xss\models;

use backend\models\BackendModel;
use yii\behaviors\TimestampBehavior;

/**
 * Class XssCookie
 * @package backend\modules\xss\models
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
class XssCookie extends BackendModel
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
            TimestampBehavior::className(),
        ];
    }
}