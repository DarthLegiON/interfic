<?php

use yii\db\Migration;
use yii\db\Schema;

class m151017_131018_parameters extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%parameters}}',
            [
                'id_Parameter' => Schema::TYPE_PK . '',
                'name' => Schema::TYPE_STRING . '(100)',
                'default_value' => Schema::TYPE_STRING . '(5000)',
                'fid_type' => Schema::TYPE_INTEGER . '(11) NOT NULL',
                'fid_quest' => Schema::TYPE_INTEGER . '(11) NOT NULL',
                'code' => Schema::TYPE_STRING . '(50) NOT NULL',
            ],
            $tableOptions
        );

        $this->createIndex('fk_Parameters_ParametersTypes1_idx', '{{%parameters}}', 'fid_type', 0);
        $this->createIndex('fk_Parameters_Quest_Versions1_idx', '{{%parameters}}', 'fid_quest', 0);
    }

    public function safeDown()
    {
        $this->dropIndex('fk_Parameters_ParametersTypes1_idx', '{{%parameters}}');
        $this->dropIndex('fk_Parameters_Quest_Versions1_idx', '{{%parameters}}');
        $this->dropTable('{{%parameters}}');
    }
}
