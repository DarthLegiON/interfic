<?php

namespace app\modules\game\controllers;

use yii\web\Controller;

class ManageController extends Controller
{
    public function actionIndex()
    {
        $this->redirect('../../frontend-only-build/index.php');
    }
}
