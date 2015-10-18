<?php

use yii\db\Migration;
use yii\db\Schema;

class m151017_131019_parameters_types extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%parameters_types}}',
            [
                'id_ParameterType' => Schema::TYPE_PK . '',
                'name' => Schema::TYPE_STRING . '(100)',
                'class_name' => Schema::TYPE_STRING . '(45)',
            ],
            $tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%parameters_types}}');
    }
}
