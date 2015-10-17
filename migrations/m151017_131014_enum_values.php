<?php

use yii\db\Migration;
use yii\db\Schema;

class m151017_131014_enum_values extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%enum_values}}',
            [
                'id_Enumeration' => Schema::TYPE_PK . '',
                'text' => Schema::TYPE_STRING . '(100)',
                'fid_parameter' => Schema::TYPE_INTEGER . '(11) NOT NULL',
                'number_value' => Schema::TYPE_INTEGER . '(11)',
            ],
            $tableOptions
        );

        $this->createIndex('fk_Enumerations_Parameters1_idx', '{{%enum_values}}', 'fid_parameter', 0);
    }

    public function safeDown()
    {
        $this->dropIndex('fk_Enumerations_Parameters1_idx', '{{%enum_values}}');
        $this->dropTable('{{%enum_values}}');
    }
}
