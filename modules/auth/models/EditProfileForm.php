<?php
/**
 * Created by PhpStorm.
 * User: Darth LegiON
 * Date: 07.05.2015
 * Time: 21:57
 */

namespace app\modules\auth\models;


use yii\base\Model;

class EditProfileForm extends Model {

    /**
     * @var string Id
     */
    public $id;
    /**
     * @var string Логин
     */
    public $username;

    /**
     * @var string Старый пароль
     */
    public $passwordOld;
    /**
     * @var string Новый пароль
     */
    public $passwordNew;
    /**
     * @var string Повтор пароля
     */
    public $passwordRepeat;
    /**
     * @var string Аватар
     */
    public $avatar;
    /**
     * @var string Описание
     */
    public $bio;
    /**
     * @var string Роль
     */
    public $role;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'required'],
            ['role', 'string'],
            ['bio', 'string', 'max' => 1000],
            [['passwordNew', 'passwordOld', 'passwordRepeat'], 'string', 'min' => 8],
            ['passwordOld', 'checkOldPassword'],
            ['passwordRepeat', 'checkRepeatedPassword'],
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
     * Проверка старого пароля
     * @param $attribute
     * @param $params
     */
    public function checkOldPassword($attribute, $params)
    {
        $user = User::findIdentity($this->id);
        if (!$user->validatePassword($this->$attribute)) {
            $this->addError($attribute, 'Пароль неверный');
        }
    }

    /**
     * Проверка поля повторного пароля
     * @param $attribute
     * @param $params
     */
    public function checkRepeatedPassword($attribute, $params)
    {
        if ($this->$attribute !== $this->passwordNew) {
            $this->addError($attribute, 'Пароли должны совпадать');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'passwordOld' => 'Старый пароль',
            'passwordNew' => 'Новый пароль',
            'passwordRepeat' => 'Повторите пароль',
            'avatar' => 'Аватар',
            'bio' => 'Подпись',
            'role' => 'Группа',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'passwordOld' => 'Если не хотите менять пароль, оставьте это поле пустым',
            'passwordNew' => 'Если не хотите менять пароль, оставьте это поле пустым',
            'passwordRepeat' => 'Если не хотите менять пароль, оставьте это поле пустым',
            'avatar' => 'Не больше 160x160px и 200 КБ, только jpg, gif или png',
            'bio' => 'Краткое описание вашего профиля'
        ];
    }

    /**
     * Возвращает список ролей в формате [код => название]
     * @return array
     */
    public function getRolesList()
    {
        $roles = \Yii::$app->authManager->getRoles();
        $return = [];
        foreach ($roles as $role) {
            $return[$role->name] = $role->description;
        }
        return $return;
    }

}