<?php

use yii\db\Migration;
use yii\db\Schema;

class m151017_131021_pictures extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%pictures}}',
            [
                'id_Picture' => Schema::TYPE_PK . '',
                'path' => Schema::TYPE_STRING . '(300) COMMENT "Путь к картинке на сервере"',
            ],
            $tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%pictures}}');
    }
}
