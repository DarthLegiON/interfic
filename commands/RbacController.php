<?php

namespace app\commands;

use app\modules\auth\models\RegisterForm;
use app\modules\base\models\User;
use Yii;

class RbacController extends \yii\console\Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        if (count($auth->getPermissions()) > 0) {
            echo "RBAC already initialized.\n";
        } else {
            echo "Starting RBAC initialization...\n";

            $play = $auth->createPermission('play');
            $play->description = 'Игра';
            $auth->add($play);
            echo "Permission play created\n";

            $createQuest = $auth->createPermission('createQuest');
            $createQuest->description = 'Создание новых квестов';
            $auth->add($createQuest);
            echo "Permission createQuest created\n";

            $editProfile = $auth->createPermission('editProfile');
            $editProfile->description = 'Редактирование своего профиля';
            $auth->add($editProfile);
            echo "Permission editProfile created\n";

            $manageQuests = $auth->createPermission('manageQuests');
            $manageQuests->description = 'Управление квестами и версиями';
            $auth->add($manageQuests);
            echo "Permission manageQuests created\n";

            $manageGames = $auth->createPermission('manageGames');
            $manageGames->description = 'Управление играми';
            $auth->add($manageGames);
            echo "Permission manageGames created\n";

            $manageUsers = $auth->createPermission('manageUsers');
            $manageUsers->description = 'Управление пользователями';
            $auth->add($manageUsers);
            echo "Permission manageUsers created\n";

            $banned = $auth->createRole('banned');
            $banned->description = 'Заблокирован';
            $auth->add($banned);
            echo "Role banned created\n";

            $player = $auth->createRole('player');
            $player->description = 'Игрок';
            $auth->add($player);
            $auth->addChild($player, $editProfile);
            $auth->addChild($player, $play);
            $auth->addChild($player, $createQuest);
            echo "Role player created\n";

            $master = $auth->createRole('master');
            $master->description = 'Гейм-мастер';
            $auth->add($master);
            $auth->addChild($master, $manageGames);
            $auth->addChild($master, $manageQuests);
            $auth->addChild($master, $player);
            echo "Role master created\n";

            $admin = $auth->createRole('admin');
            $admin->description = 'Администратор';
            $auth->add($admin);
            $auth->addChild($admin, $manageUsers);
            $auth->addChild($admin, $master);
            echo "Role admin created\n";

            echo "RBAC initialization done!\n";
        }


    }

    public function actionCreateAdmin()
    {
        $admins = User::find()
            ->innerJoin('auth_assignment', 'user_id = id_User')
            ->where(['item_name' => 'admin'])
            ->all();
        if (count($admins) > 0) {
            echo "Admin user already exists!\n";
        } else {

            $settings = Yii::$app->params['admin'];

            $form = new RegisterForm([
                'username' => $settings['login'],
                'password' => $settings['password'],
                'passwordRepeat' => $settings['password'],
                'email' => $settings['email'],
            ]);

            User::registerUser($form);

            echo "User {$settings['login']} created, password: {$settings['password']}.\n";
        }

    }

}
