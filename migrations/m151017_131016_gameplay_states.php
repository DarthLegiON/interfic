<?php

use yii\db\Migration;
use yii\db\Schema;

class m151017_131016_gameplay_states extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%gameplay_states}}',
            [
                'id_Gameplay_State' => Schema::TYPE_PK . '',
                'fid_game_instance' => Schema::TYPE_INTEGER . '(11) NOT NULL',
                'fid_Stage' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            ],
            $tableOptions
        );

        $this->createIndex('fk_Gameplay_States_Game_Instances1_idx', '{{%gameplay_states}}', 'fid_game_instance', 0);
        $this->createIndex('fk_Gameplay_States_Stages1_idx', '{{%gameplay_states}}', 'fid_Stage', 0);
    }

    public function safeDown()
    {
        $this->dropIndex('fk_Gameplay_States_Game_Instances1_idx', '{{%gameplay_states}}');
        $this->dropIndex('fk_Gameplay_States_Stages1_idx', '{{%gameplay_states}}');
        $this->dropTable('{{%gameplay_states}}');
    }
}
