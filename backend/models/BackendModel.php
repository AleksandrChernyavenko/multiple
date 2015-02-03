<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 01.02.2015
 * Time: 20:07
 */

namespace backend\models;


use yii\db\ActiveRecord;

/**
 * Class BackendModel
 * @package backend\models
 *
 * @property string $displayName
 */
class BackendModel extends ActiveRecord
{
    /**
     * @param string $id
     * @param string $name
     * @return string
     */
    public function getDisplayName($id = 'id', $name = 'name')
    {
        return $this->$id.', '.$this->$name;
    }
}