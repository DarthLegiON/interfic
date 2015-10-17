<?php
/**
 * Created by PhpStorm.
 * User: Darth LegiON
 * Date: 05.05.2015
 * Time: 13:30
 */

namespace app\modules\auth\models;

use yii\base\Model;
use app\modules\base\models\User as BaseUser;

class RegisterForm extends Model {

    /**
     * @var string Логин
     */
    public $username;
    /**
     * @var string Пароль
     */
    public $password;
    /**
     * @var string Повтор пароля
     */
    public $passwordRepeat;
    /**
     * @var string Аватар
     */
    public $avatar;
    /**
     * @var string E-mail
     */
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'passwordRepeat', 'email'], 'required'],
            ['email', 'email'],
            ['passwordRepeat', 'checkRepeatedPassword'],
            [['password', 'passwordRepeat'], 'string', 'min' => 8],
            ['username', 'checkUsername'],
            [['username'], 'string', 'max' => 45],
            [['email'], 'string', 'max' => 100],
            ['email', 'checkEmail'],
            ['avatar', 'image',
                'mimeTypes' => ['image/png','image/jpeg', 'image/gif'],
                'skipOnEmpty' => true,
                'wrongMimeType' => 'Неверный тип файла',
                'maxSize' => 200000,
                'tooBig' => 'Файл слишком большой',
                'maxHeight' => 160,
                'maxWidth' => 160,
                'overWidth' => 'Картинка слишком крупная',
                'overHeight' => 'Картинка слишком крупная',
            ],
        ];
    }

    /**
     * Проверка поля повторного пароля
     * @param $attribute
     * @param $params
     */
    public function checkRepeatedPassword($attribute, $params)
    {
        if ($this->$attribute !== $this->password) {
            $this->addError($attribute, 'Пароли должны совпадать');
        }
    }

    /**
     * Проверка логина на уникальность
     * @param $attribute
     * @param $params
     */
    public function checkUsername($attribute, $params)
    {
        $usersFound = BaseUser::findAll(['lower(login)' => strtolower($this->$attribute)]);
        if (count($usersFound) > 0) {
            $this->addError($attribute, 'Логин уже занят');
        }
    }

    /**
     * Проверка E-mail на уникальность
     * @param $attribute
     * @param $params
     */
    public function checkEmail($attribute, $params)
    {
        $usersFound = BaseUser::findAll(['email' => $this->$attribute]);
        if (count($usersFound) > 0) {
            $this->addError($attribute, 'E-mail уже занят');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'passwordRepeat' => 'Повторите пароль',
            'avatar' => 'Аватар',
            'email' => 'Адрес E-mail',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'avatar' => 'Не больше 160x160px и 200 КБ, только jpg, gif или png',
            'email' => 'Введите существующий E-mail',
        ];
    }


}