<?php

use yii\db\Migration;
use yii\db\Schema;

class m151017_131024_rel_stages_answers extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%rel_stages_answers}}',
            [
                'id_Rel_Stage_Answer' => Schema::TYPE_PK . '',
                'fid_stage' => Schema::TYPE_INTEGER . '(11) NOT NULL',
                'fid_answer' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            ],
            $tableOptions
        );

        $this->createIndex('fk_rel_stage_answer_idx', '{{%rel_stages_answers}}', 'fid_stage', 0);
        $this->createIndex('fk_rel_answer_stage_idx', '{{%rel_stages_answers}}', 'fid_answer', 0);
    }

    public function safeDown()
    {
        $this->dropIndex('fk_rel_stage_answer_idx', '{{%rel_stages_answers}}');
        $this->dropIndex('fk_rel_answer_stage_idx', '{{%rel_stages_answers}}');
        $this->dropTable('{{%rel_stages_answers}}');
    }
}
