<?php
/**
 * Created by PhpStorm.
 * User: Darth LegiON
 * Date: 20.04.2015
 * Time: 0:39
 */

namespace app\controllers;
use yii\web\Controller;


class GameController extends Controller{
    public function actions()
    {
        return [
            'play' => 'app\controllers\actions\game\PlayAction',
        ];
    }


}