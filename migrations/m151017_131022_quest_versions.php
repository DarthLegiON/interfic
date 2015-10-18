<?php

use yii\db\Schema;
use yii\db\Migration;

class m151017_131022_quest_versions extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%quest_versions}}',
            [
                'id_Quest_Version'=> Schema::TYPE_PK.'',
                'fid_quest'=> Schema::TYPE_INTEGER.'(11) NOT NULL',
                'name'=> Schema::TYPE_STRING.'(256) NOT NULL COMMENT "Название"',
                'description'=> Schema::TYPE_STRING.'(1000) COMMENT "Описание"',
                'release'=> Schema::TYPE_INTEGER.'(11) NOT NULL DEFAULT "0" COMMENT "Версия релиза"',
                'iteration'=> Schema::TYPE_INTEGER.'(11) NOT NULL DEFAULT "0" COMMENT "Номер итерации"',
                'save_date'=> Schema::TYPE_DATETIME.' NOT NULL COMMENT "Дата сохранения версии"',
                'fid_creator_user'=> Schema::TYPE_INTEGER.'(11)',
                'version_name'=> Schema::TYPE_STRING.'(150)',
                'fid_start_version'=> Schema::TYPE_INTEGER.'(11)',
                ],
            $tableOptions
        );

        $this->createIndex('fk_version_quest_idx', '{{%quest_versions}}','fid_quest',0);
        $this->createIndex('fid_creator_user', '{{%quest_versions}}','fid_creator_user',0);
        $this->createIndex('fid_start_version', '{{%quest_versions}}','fid_start_version',0);
    }

    public function safeDown()
    {
        $this->dropIndex('fk_version_quest_idx', '{{%quest_versions}}');
        $this->dropIndex('fid_creator_user', '{{%quest_versions}}');
        $this->dropIndex('fid_start_version', '{{%quest_versions}}');
        $this->dropTable('{{%quest_versions}}');
    }
}
