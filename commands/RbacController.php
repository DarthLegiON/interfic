<?php

namespace app\commands;

use Yii;

class RbacController extends \yii\console\Controller
{
    public function actionInit()
    {
        echo 'Starting...\n';

        $auth = Yii::$app->authManager;


        $play = $auth->createPermission('play');
        $play->description = 'Игра';
        $auth->add($play);
        echo 'Permission play created\n';

        $createQuest = $auth->createPermission('createQuest');
        $createQuest->description = 'Создание новых квестов';
        $auth->add($createQuest);
        echo 'Permission createQuest created\n';

        $editProfile = $auth->createPermission('editProfile');
        $editProfile->description = 'Редактирование своего профиля';
        $auth->add($editProfile);
        echo 'Permission editProfile created\n';

        $manageQuests = $auth->createPermission('manageQuests');
        $manageQuests->description = 'Управление квестами и версиями';
        $auth->add($manageQuests);
        echo 'Permission manageQuests created\n';

        $manageGames = $auth->createPermission('manageGames');
        $manageGames->description = 'Управление играми';
        $auth->add($manageGames);
        echo 'Permission manageGames created\n';

        $manageUsers = $auth->createPermission('manageUsers');
        $manageUsers->description = 'Управление пользователями';
        $auth->add($manageUsers);
        echo 'Permission manageUsers created\n';

        $banned = $auth->createRole('banned');
        $banned->description = 'Заблокирован';
        $auth->add($banned);
        echo 'Role "banned" created\n';

        $player = $auth->createRole('player');
        $player->description = 'Игрок';
        $auth->add($player);
        $auth->addChild($player, $editProfile);
        $auth->addChild($player, $play);
        echo 'Role "player" created\n';

        $master = $auth->createRole('master');
        $master->description = 'Гейм-мастер';
        $auth->add($master);
        $auth->addChild($master, $manageGames);
        $auth->addChild($master, $manageQuests);
        $auth->addChild($master, $player);
        echo 'Role "master" created\n';

        $admin = $auth->createRole('admin');
        $admin->description = 'Администратор';
        $auth->add($admin);
        $auth->addChild($admin, $manageUsers);
        $auth->addChild($admin, $master);
        echo 'Role "admin" created\n';

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($admin, 1);
    }

}
