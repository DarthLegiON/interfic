<?php

use yii\db\Migration;
use yii\db\Schema;

class m151017_131023_quests extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%quests}}',
            [
                'id_quest' => Schema::TYPE_PK . '',
                'fid_production_version' => Schema::TYPE_INTEGER . '(11) COMMENT "Окончательная версия"',
                'fid_test_version' => Schema::TYPE_INTEGER . '(11) COMMENT "Тестовая версия"',
                'fid_creator_user' => Schema::TYPE_INTEGER . '(11) NOT NULL COMMENT "Автор"',
            ],
            $tableOptions
        );

        $this->createIndex('fk_production_version_idx', '{{%quests}}', 'fid_production_version', 0);
        $this->createIndex('fk_test_version_idx', '{{%quests}}', 'fid_test_version', 0);
        $this->createIndex('fk_quest_user_idx', '{{%quests}}', 'fid_creator_user', 0);
    }

    public function safeDown()
    {
        $this->dropIndex('fk_production_version_idx', '{{%quests}}');
        $this->dropIndex('fk_test_version_idx', '{{%quests}}');
        $this->dropIndex('fk_quest_user_idx', '{{%quests}}');
        $this->dropTable('{{%quests}}');
    }
}
