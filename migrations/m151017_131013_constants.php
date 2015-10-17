<?php

use yii\db\Migration;
use yii\db\Schema;

class m151017_131013_constants extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%constants}}',
            [
                'id_Constant' => Schema::TYPE_PK . '',
                'name' => Schema::TYPE_STRING . '(100)',
                'fid_action' => Schema::TYPE_INTEGER . '(11)',
                'fid_quest' => Schema::TYPE_INTEGER . '(11)',
            ],
            $tableOptions
        );

        $this->createIndex('fk_constant_action_idx', '{{%constants}}', 'fid_action', 0);
        $this->createIndex('fk_Constants_Quest_Versions1_idx', '{{%constants}}', 'fid_quest', 0);
    }

    public function safeDown()
    {
        $this->dropIndex('fk_constant_action_idx', '{{%constants}}');
        $this->dropIndex('fk_Constants_Quest_Versions1_idx', '{{%constants}}');
        $this->dropTable('{{%constants}}');
    }
}
