<?php

namespace app\modules\base\models;

use Yii;

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
        ];
    }

    public function getRole()
    {
        return array_values(Yii::$app->authManager->getRolesByUser($this->id_User))[0]->description;
    }

    public function getQuests()
    {
        return [];
    }

    public function getGamesCount()
    {
        return 0;
    }
}
