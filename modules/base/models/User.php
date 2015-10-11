<?php

namespace app\modules\base\models;

use Yii;
use yii\web\Application;

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
}
