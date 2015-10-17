<?php

use yii\db\Migration;
use yii\db\Schema;

class m151017_131029_users extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%users}}',
            [
                'id_User' => Schema::TYPE_PK . ' COMMENT "#"',
                'login' => Schema::TYPE_STRING . '(45) NOT NULL COMMENT "Логин"',
                'password_hash' => Schema::TYPE_STRING . '(60) NOT NULL COMMENT "Хэш пароля"',
                'avatar' => Schema::TYPE_STRING . '(256) COMMENT "Ссылка к аватарке"',
                'code' => Schema::TYPE_STRING . '(10) COMMENT "Код"',
                'email' => Schema::TYPE_STRING . '(100) NOT NULL COMMENT "Адрес E-mail"',
                'ip_address' => Schema::TYPE_STRING . '(11) NOT NULL COMMENT "Регистрационный IP-адрес"',
                'bio' => Schema::TYPE_STRING . '(1000) COMMENT "Информация о пользователе"',
                'registration_time' => Schema::TYPE_DATETIME . '',
            ],
            $tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
