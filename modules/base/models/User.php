<?php

namespace app\modules\base\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "Users".
 *
 * @property integer $id_User
 * @property string $login
 * @property string $password_hash
 * @property string $avatar
 * @property string $code
 * @property string $email
 * @property string $ip_address
 * @property string $bio
 * @property string $registration_time
 * @property string $regDuration
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Users';
    }

    public static function registerUser($form, $role = 'player')
    {
        $userModel = new User();

        $userModel->login = $form->username;
        if (Yii::$app->request instanceof \yii\web\Request) {
            $userModel->ip_address = Yii::$app->request->getUserIP();
        } else {
            $userModel->ip_address = '127.0.0.1';
        }
        $userModel->email = $form->email;
        $userModel->registration_time = (new \DateTime('now'))->format('Y-m-d H:i:s');
        $userModel->password_hash = Yii::$app->getSecurity()->generatePasswordHash($form->password);
        if (isset($form->avatar)) {
            $userModel->avatar = self::saveAvatar(UploadedFile::getInstance($form, 'avatar'));
        }
        if ($userModel->save()) {
            Yii::$app->authManager->assign(Yii::$app->authManager->getRole($role), $userModel->id_User);
            return $userModel->id_User;
        } else {
            return false;
        }
    }

    /**
     * Сохраняет в особую папку аватар пользователя и возвращает ссылку на этот файл
     * @param UploadedFile $file
     * @return string Имя файла
     */
    public static function saveAvatar($file)
    {
        if (isset($file)) {
            $filename = uniqid('av_') . '.' . $file->extension;
            if ($file->saveAs(Yii::$app->params['avatars-path'] . $filename)) {
                return $filename;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * Возвращает список ролей в формате [код => название]
     * @return array
     */
    public static function getRolesList()
    {
        $roles = \Yii::$app->authManager->getRoles();
        $return = [];
        foreach ($roles as $role) {
            $return[$role->name] = $role->description;
        }
        return $return;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['login', 'password_hash', 'email', 'ip_address'], 'required'],
            [['bio'], 'string'],
            [['registration_time'], 'safe'],
            [['login'], 'string', 'max' => 45],
            [['password_hash'], 'string', 'max' => 60],
            [['avatar'], 'string', 'max' => 256],
            [['code'], 'string', 'max' => 10],
            [['email'], 'string', 'max' => 100],
            [['ip_address'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_User' => '#',
            'login' => 'Логин',
            'password_hash' => 'Хэш пароля',
            'avatar' => 'Ссылка к аватарке',
            'code' => 'Код',
            'email' => 'Адрес E-mail',
            'ip_address' => 'Регистрационный IP-адрес',
            'bio' => 'Информация о пользователе',
            'role' => 'Группа',
            'avatarFullPath' => 'Аватар',
            'quests' => 'Квесты',
            'gamesCount' => 'Сыграно игр',
            'registration_time' => 'Дата-время регистрации',
        ];
    }

    public function getRoleName()
    {
        return array_values(Yii::$app->authManager->getRolesByUser($this->id_User))[0]->description;
    }

    public function getRole()
    {
        return array_keys(Yii::$app->authManager->getRolesByUser($this->id_User))[0];
    }

    public function getQuests()
    {
        return [];
    }

    public function getGamesCount()
    {
        return 0;
    }

    public function getRegDuration()
    {
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $this->registration_time)->setTime(0, 0, 0);
        return $date->diff(new \DateTime('now'))->days;
        //return null;
    }

    public function getAvatarFullPath()
    {
        return '/' . Yii::$app->params['avatars-path'] . $this->avatar;
    }
}
