<?php

use yii\db\Migration;
use yii\db\Schema;

class m151017_131027_template_variables extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%template_variables}}',
            [
                'id_temp_var' => Schema::TYPE_PK . '',
                'fid_template' => Schema::TYPE_INTEGER . '(11) NOT NULL',
                'code' => Schema::TYPE_STRING . '(20) NOT NULL',
                'is_eval' => Schema::TYPE_BOOLEAN . '(1) NOT NULL DEFAULT "1"',
                'value' => Schema::TYPE_STRING . '(500) NOT NULL',
            ],
            $tableOptions
        );

        $this->createIndex('id_temp_var', '{{%template_variables}}', 'id_temp_var', 1);
        $this->createIndex('fid_template', '{{%template_variables}}', 'fid_template', 0);
    }

    public function safeDown()
    {
        $this->dropIndex('id_temp_var', '{{%template_variables}}');
        $this->dropIndex('fid_template', '{{%template_variables}}');
        $this->dropTable('{{%template_variables}}');
    }
}
