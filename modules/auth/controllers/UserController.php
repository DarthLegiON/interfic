<?php

namespace app\modules\auth\controllers;

use Yii;
use yii\web\Controller;
use app\modules\auth\models\LoginForm;
use app\modules\auth\models\RegisterForm;
use app\modules\auth\models\EditProfileForm;
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
                    [
                        'actions' => ['edit-profile'],
                        'allow' => true,
                        'roles' => ['editProfile'],
                    ],
                    [
                        'actions' => ['register'],
                        'allow' => false,
                        'roles' => ['@'],
                    ]
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
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

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

    public function actionProfile($id = null)
    {
        $user = $this->getUserById($id);

        return $this->render('profile', [
            'user' => $user,
            'own' => $id == Yii::$app->user->id || !isset($id),
            'admin' => Yii::$app->user->can('manageUsers'), /** @TODO Добавить право на редактирование админу */
        ]);
    }

    public function actionEditProfile($id = null)
    {
        $id = (Yii::$app->request->isPost) ? Yii::$app->request->post('EditProfileForm')['id'] : $id;
        if (!isset($id) || $id == Yii::$app->user->id || Yii::$app->user->can('manageUsers')) {
            $model = new EditProfileForm();
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($this->saveUser($model)) {
                        return $this->redirect(['profile' . '?id=' . $model->id]);
                    } else {
                        return $this->render('edit_profile', [
                            'model' => $model,
                        ]);
                    }
                }
            } else {
                $user = $this->getUserById($id);

                $model->id = $user->id_User;
                $model->username = $user->login;
                $model->bio = $user->bio;

                return $this->render('edit_profile', [
                    'model' => $model,
                ]);
            }

            return $this->render('edit_profile', [
                'model' => $model,
            ]);
        } else {
            return $this->goHome();
        }
    }

    /**
     * Регистрирует пользователя
     * @param RegisterForm $form
     * @return integer|boolean ID пользователя, false, если неудача
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
     * Сохраняет данные о пользователе
     * @param EditProfileForm $form
     * @return boolean false, если неудача
     */
    private function saveUser($form)
    {
        /**
         * @var User $userModel
         */
        $userModel = $this->getUserById($form->id);
        if (!empty($form->passwordNew)) {
            $userModel->password_hash = Yii::$app->getSecurity()->generatePasswordHash($form->passwordNew);
        }
        if (!empty($form->avatar)) {
            $userModel->avatar = $this->saveAvatar($file = UploadedFile::getInstance($form, 'avatar'));
        }
        $userModel->bio = $form->bio;

        return $userModel->save();
    }

    /**
     * @param UploadedFile $file
     * @return string Имя файла
     */
    private function saveAvatar($file)
    {
        if (isset($file)) {
            $filename = uniqid('av_') . '.' . $file->extension;
            $file->saveAs('uploads/avatars/' . $filename);
            return $filename;
        }
    }

    /**
     * @param $id
     * @return User
     */
    private function getUserById($id)
    {
        if (!isset($id)) {
            if (\Yii::$app->user->isGuest) {
                return $this->goHome();
            } else {
                $id = Yii::$app->user->id;

            }
        }

        return User::findOne(['id_User' => $id]);
    }


}
