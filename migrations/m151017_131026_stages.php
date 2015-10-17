<?php

use yii\db\Migration;
use yii\db\Schema;

class m151017_131026_stages extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%stages}}',
            [
                'id_Stage' => Schema::TYPE_PK . '',
                'class' => Schema::TYPE_STRING . '(100) NOT NULL DEFAULT "Stage"',
                'start' => Schema::TYPE_BOOLEAN . '(1) NOT NULL DEFAULT "0" COMMENT "Флаг стартового состояния"',
                'name' => Schema::TYPE_STRING . '(100)',
                'fid_picture' => Schema::TYPE_INTEGER . '(11)',
                'fid_before_action' => Schema::TYPE_INTEGER . '(11) COMMENT "Действие, выполняемое в начале перехода в состояние"',
                'fid_after_action' => Schema::TYPE_INTEGER . '(11) COMMENT "Действие, выполняемое после выхода из состояния"',
                'fid_quest_version' => Schema::TYPE_INTEGER . '(11) NOT NULL',
                'fid_params_template' => Schema::TYPE_INTEGER . '(11)',
            ],
            $tableOptions
        );

        $this->createIndex('fk_stage_picture_idx', '{{%stages}}', 'fid_picture', 0);
        $this->createIndex('fk_stage_before_idx', '{{%stages}}', 'fid_before_action', 0);
        $this->createIndex('fk_stage_after_action_idx', '{{%stages}}', 'fid_after_action', 0);
        $this->createIndex('fk_Stages_Quest_Versions1_idx', '{{%stages}}', 'fid_quest_version', 0);
        $this->createIndex('fk_Stages_Template_Variables1_idx', '{{%stages}}', 'fid_params_template', 0);
    }

    public function safeDown()
    {
        $this->dropIndex('fk_stage_picture_idx', '{{%stages}}');
        $this->dropIndex('fk_stage_before_idx', '{{%stages}}');
        $this->dropIndex('fk_stage_after_action_idx', '{{%stages}}');
        $this->dropIndex('fk_Stages_Quest_Versions1_idx', '{{%stages}}');
        $this->dropIndex('fk_Stages_Template_Variables1_idx', '{{%stages}}');
        $this->dropTable('{{%stages}}');
    }
}
