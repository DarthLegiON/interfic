<?php

namespace app\modules\game\controllers;

use yii\web\Controller;

class ManageController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
