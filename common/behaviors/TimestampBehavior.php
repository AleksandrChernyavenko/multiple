<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 02.02.2015
 * Time: 12:04
 */

namespace common\behaviors;

use yii\db\BaseActiveRecord;

class TimestampBehavior extends \yii\behaviors\TimestampBehavior
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {

            if($this->owner->canSetProperty($this->updatedAtAttribute)) {
                $this->attributes = [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->createdAtAttribute, $this->updatedAtAttribute],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->updatedAtAttribute,
                ];
            }
            else {
                $this->attributes = [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => $this->createdAtAttribute,
                ];
            }


        }
    }

}