<?php

use yii\db\Migration;
use yii\db\Schema;

class m151017_131012_answers extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%answers}}',
            [
                'id_Answer' => Schema::TYPE_PK . '',
                'class' => Schema::TYPE_STRING . '(45) DEFAULT "Answer"',
                'text' => Schema::TYPE_STRING . '(45)',
                'active' => Schema::TYPE_BOOLEAN . '(1) DEFAULT "1"',
                'fid_action' => Schema::TYPE_INTEGER . '(11)',
                'icon' => Schema::TYPE_STRING . '(45) DEFAULT "angle-right"',
                'fid_quest' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            ],
            $tableOptions
        );

        $this->createIndex('fk_answer_action_idx', '{{%answers}}', 'fid_action', 0);
        $this->createIndex('fk_Answers_Quest_Versions1_idx', '{{%answers}}', 'fid_quest', 0);
    }

    public function safeDown()
    {
        $this->dropIndex('fk_answer_action_idx', '{{%answers}}');
        $this->dropIndex('fk_Answers_Quest_Versions1_idx', '{{%answers}}');
        $this->dropTable('{{%answers}}');
    }
}
