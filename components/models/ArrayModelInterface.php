<?php
/**
 * Created by PhpStorm.
 * User: Darth LegiON
 * Date: 11.10.2015
 * Time: 18:35
 */

namespace app\components\models;


interface ArrayModelInterface
{
    /**
     * Класс, элементы которого содержит модель
     * @return mixed
     */
    public static function modelClassName();

}