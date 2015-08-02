<?php
/**
 * Created by PhpStorm.
 * User: Darth LegiON
 * Date: 02.08.2015
 * Time: 19:24
 */

namespace app\modules\base\models\interfaces;

/**
 * Интерфейс модели с ограниченным доступом по пользователю
 * @package app\modules\base\models\interfaces
 */
interface Restricted
{
    /**
     * Проверяет, есть ли у пользователя доступ к записи
     * @return bool
     */
    public function checkPermission();
}