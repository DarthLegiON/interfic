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
use yii\data\ActiveDataProvider;
use app\modules\auth\models\UserSearch;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'edit-profile'],
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

    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Вход пользователя
     * @return string|\yii\web\Response
     */
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

    /**
     * Выход пользователя
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Регистрация пользователя
     * @return string|\yii\web\Response
     */
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

    /**
     * Профиль пользователя
     * @param null $id
     * @return string
     */
    public function actionProfile($id = null)
    {
        $user = $this->getUserById($id);

        return $this->render('profile', [
            'user' => $user,
            'own' => $id == Yii::$app->user->id || !isset($id),
            'admin' => Yii::$app->user->can('manageUsers'),
        ]);
    }

    /**
     * Редактирование профиля пользователя
     * @param null $id
     * @return string|\yii\web\Response
     */
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
                if (isset($user->id_User) && $id != Yii::$app->user->id && Yii::$app->user->can('manageUsers')) {
                    $model->role = array_values(Yii::$app->authManager->getRolesByUser($user->id_User))[0]->name;
                }
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
        return User::registerUser($form);
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
        $avatarFile = UploadedFile::getInstance($form, 'avatar');
        if (isset($avatarFile)) {
            if (isset($userModel->avatar)) {
                @unlink(Yii::$app->params['avatars-path'] . $userModel->avatar);
            }
            $userModel->avatar = User::saveAvatar($avatarFile);
        }

        if (isset($form->role) && Yii::$app->user->can('manageUsers')) {
            Yii::$app->authManager->revokeAll($form->id);
            Yii::$app->authManager->assign(Yii::$app->authManager->getRole($form->role), $form->id);
        }
        $userModel->bio = $this->prepareBio($form->bio);

        /*var_dump($form);
        var_dump($userModel);*/
        return $userModel->save();
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

    /**
     * Удаляет из подписи лишние теги
     * @param $text
     * @return string
     */
    private function prepareBio($text)
    {
        return strip_tags($text, '<div><p><span><strong><em><li><ul><del><a><img><u>');
    }


}
