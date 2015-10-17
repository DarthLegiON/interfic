<?php

use yii\db\Migration;
use yii\db\Schema;

class m151017_131025_rel_stages_templates extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%rel_stages_templates}}',
            [
                'id_Rel_Stage_Template' => Schema::TYPE_PK . '',
                'fid_stage' => Schema::TYPE_INTEGER . '(11) NOT NULL',
                'fid_template' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            ],
            $tableOptions
        );

        $this->createIndex('fk_rel_stage_template_idx', '{{%rel_stages_templates}}', 'fid_stage', 0);
        $this->createIndex('fk_rel_template_stage_idx', '{{%rel_stages_templates}}', 'fid_template', 0);
    }

    public function safeDown()
    {
        $this->dropIndex('fk_rel_stage_template_idx', '{{%rel_stages_templates}}');
        $this->dropIndex('fk_rel_template_stage_idx', '{{%rel_stages_templates}}');
        $this->dropTable('{{%rel_stages_templates}}');
    }
}
