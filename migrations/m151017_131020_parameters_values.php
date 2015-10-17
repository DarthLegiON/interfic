<?php

use yii\db\Migration;
use yii\db\Schema;

class m151017_131020_parameters_values extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%parameters_values}}',
            [
                'id_Param_Value' => Schema::TYPE_PK . '',
                'value' => Schema::TYPE_STRING . '(5000)',
                'fid_Gameplay_State' => Schema::TYPE_INTEGER . '(11) NOT NULL',
                'fid_Parameter' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            ],
            $tableOptions
        );

        $this->createIndex('fk_Parameters_Values_Gameplay_States1_idx', '{{%parameters_values}}', 'fid_Gameplay_State', 0);
        $this->createIndex('fk_Parameters_Values_Parameters1_idx', '{{%parameters_values}}', 'fid_Parameter', 0);
    }

    public function safeDown()
    {
        $this->dropIndex('fk_Parameters_Values_Gameplay_States1_idx', '{{%parameters_values}}');
        $this->dropIndex('fk_Parameters_Values_Parameters1_idx', '{{%parameters_values}}');
        $this->dropTable('{{%parameters_values}}');
    }
}
