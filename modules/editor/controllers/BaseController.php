<?php
/**
 * Created by PhpStorm.
 * User: Darth LegiON
 * Date: 02.08.2015
 * Time: 21:19
 */

namespace app\modules\editor\controllers;


use app\modules\base\models\interfaces\Restricted;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * Базовый контроллер для редактора
 * @package app\modules\editor\controllers
 */
abstract class BaseController extends Controller
{
    /**
     * Проверяет доступ к записи
     * @param Restricted|null $record
     * @return bool
     * @throws ForbiddenHttpException если нет доступа
     * @throws NotFoundHttpException если запись не существует
     */
    protected function checkAccess($record)
    {
        if (empty($record)) {
            throw new NotFoundHttpException('Запись не найдена');
        } else if ($record instanceof Restricted && $record->checkPermission()) {
            return true;
        } else {
            throw new ForbiddenHttpException('Вы не имеете доступа к этой записи');
        }
    }
}