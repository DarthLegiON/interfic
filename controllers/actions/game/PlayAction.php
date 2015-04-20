<?php
/**
 * Created by PhpStorm.
 * User: Darth LegiON
 * Date: 20.04.2015
 * Time: 0:41
 */

namespace app\controllers\actions\game;

use yii\base\Action;

class PlayAction extends Action {

    public function runWithParams($params)
    {
        /**
         * @todo запуск игры
         */
        return $this->controller->render('play/main_interface');
    }

}