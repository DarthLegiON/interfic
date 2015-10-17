<?php

use yii\db\Migration;
use yii\db\Schema;

class m151017_131028_templates extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%templates}}',
            [
                'id_template' => Schema::TYPE_PK . '',
                'name' => Schema::TYPE_STRING . '(50) NOT NULL',
                'text' => Schema::TYPE_TEXT . '',
                'fid_quest_version' => Schema::TYPE_INTEGER . '(11)',
                'class' => Schema::TYPE_STRING . '(100) NOT NULL DEFAULT "Template" COMMENT "Класс, представляющий сущность"',
                'order' => Schema::TYPE_INTEGER . '(11) DEFAULT "0" COMMENT "Столбец для упорядочивания шаблонов в состоянии"',
            ],
            $tableOptions
        );

        $this->createIndex('name', '{{%templates}}', 'name', 0);
        $this->createIndex('id_template', '{{%templates}}', 'id_template', 0);
        $this->createIndex('fk_template_quest_idx', '{{%templates}}', 'fid_quest_version', 0);
    }

    public function safeDown()
    {
        $this->dropIndex('name', '{{%templates}}');
        $this->dropIndex('id_template', '{{%templates}}');
        $this->dropIndex('fk_template_quest_idx', '{{%templates}}');
        $this->dropTable('{{%templates}}');
    }
}
