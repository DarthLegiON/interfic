<?php

use yii\db\Migration;
use yii\db\Schema;

class m151017_131011_actions extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%actions}}',
            [
                'id_Action' => Schema::TYPE_PK . '',
                'script' => Schema::TYPE_TEXT . ' NOT NULL COMMENT "Текст выполняемого скрипта"',
                'fid_quest' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            ],
            $tableOptions
        );

        $this->createIndex('fk_Actions_Quest_Versions1_idx', '{{%actions}}', 'fid_quest', 0);
    }

    public function safeDown()
    {
        $this->dropIndex('fk_Actions_Quest_Versions1_idx', '{{%actions}}');
        $this->dropTable('{{%actions}}');
    }
}
