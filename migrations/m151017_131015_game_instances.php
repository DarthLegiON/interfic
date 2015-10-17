<?php

use yii\db\Migration;
use yii\db\Schema;

class m151017_131015_game_instances extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%game_instances}}',
            [
                'id_game_instance' => Schema::TYPE_PK . '',
                'fid_game' => Schema::TYPE_INTEGER . '(11) NOT NULL',
                'fid_user' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            ],
            $tableOptions
        );

        $this->createIndex('id_game_instance_UNIQUE', '{{%game_instances}}', 'id_game_instance', 1);
        $this->createIndex('fk_instance_game_idx', '{{%game_instances}}', 'fid_game', 0);
        $this->createIndex('fk_Game_Instances_Users1_idx', '{{%game_instances}}', 'fid_user', 0);
    }

    public function safeDown()
    {
        $this->dropIndex('id_game_instance_UNIQUE', '{{%game_instances}}');
        $this->dropIndex('fk_instance_game_idx', '{{%game_instances}}');
        $this->dropIndex('fk_Game_Instances_Users1_idx', '{{%game_instances}}');
        $this->dropTable('{{%game_instances}}');
    }
}
