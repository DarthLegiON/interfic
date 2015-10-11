<?php
/**
 * Created by PhpStorm.
 * User: Darth LegiON
 * Date: 12.10.2015
 * Time: 0:25
 */

namespace app\modules\editor\models;


use app\modules\base\models\EnumValue;
use app\components\models\ModelCollection;

class EnumValuesForm extends ModelCollection
{

    /**
     * Класс, элементы которого содержит модель
     * @return mixed
     */
    public static function modelClassName()
    {
        return EnumValue::className();
    }
}