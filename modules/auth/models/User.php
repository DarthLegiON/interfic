<?php

namespace app\modules\auth\models;

use Yii;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $authKey;
    public $avatar;

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::getFromDBModel(\app\modules\base\models\User::findOne(['id_User' => $id]));
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::getFromDBModel(\app\modules\base\models\User::findOne(['lower(login)' => strtolower($username)]));
    }

    public static function getIp()
    {
        if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            return $_SERVER["REMOTE_ADDR"];
        }
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->authKey);
    }

    /**
     * @param \app\modules\base\models\User $model
     */
    private static function getFromDBModel($model)
    {
        if (isset($model)) {
            return new static([
                'id' => $model->id_User,
                'username' => $model->login,
                'authKey' => $model->password_hash,
                'avatar' => $model->avatar,
            ]);
        } else {
            return null;
        }
    }
}
