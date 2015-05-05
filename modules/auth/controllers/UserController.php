<?php

namespace app\modules\auth\controllers;

use Yii;
use yii\web\Controller;
use app\modules\auth\models\LoginForm;
use app\modules\auth\models\RegisterForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\modules\base\models\User;
use yii\web\UploadedFile;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRegister()

    {
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {
                $registerResult = $this->registerUser($model);
                if ($registerResult !== false) {
                    $loginModel = new LoginForm();
                    $loginModel->username = $model->username;
                    return $this->render('end_register', [
                        'model' => $loginModel,
                        'id' => $registerResult,
                    ]);
                } else {
                    return $this->render('register', [
                        'model' => $model,
                    ]);
                }

            }

        }

        return $this->render('register', [
            'model' => $model,
        ]);

    }

    /**
     * Регистрирует пользователя
     * @param RegisterForm $form
     * @return boolean true, если удача, false, если неудача
     */
    private function registerUser($form)
    {
        $userModel = new User();

        $userModel->login = $form->username;
        $userModel->ip_address = Yii::$app->request->getUserIP();
        $userModel->email = $form->email;
        $userModel->password_hash = Yii::$app->getSecurity()->generatePasswordHash($form->password);
        if (isset($form->avatar)) {
            $userModel->avatar = $this->saveAvatar($file = UploadedFile::getInstance($form, 'avatar'));
        }
        if ($userModel->save()) {
            return $userModel->id_User;
        } else {
            return false;
        }

    }

    /**
     * @param UploadedFile $file
     * @return string имя файла
     */
    private function saveAvatar($file)
    {
        if (isset($file)) {
            $filename = uniqid('av_') . '.' . $file->extension;
            $file->saveAs('uploads/avatars/' . $filename);
            return $filename;
        }
    }

}
