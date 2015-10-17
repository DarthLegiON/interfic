<?php

use yii\db\Migration;
use yii\db\Schema;

class m151017_131017_games extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%games}}',
            [
                'id_game' => Schema::TYPE_PK . '',
                'start_time' => Schema::TYPE_DATETIME . ' COMMENT "Время начала игры"',
                'finish_time' => Schema::TYPE_DATETIME . ' COMMENT "Время окончания игры"',
                'fid_quest' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            ],
            $tableOptions
        );

        $this->createIndex('fk_Games_Quest_Versions1_idx', '{{%games}}', 'fid_quest', 0);
    }

    public function safeDown()
    {
        $this->dropIndex('fk_Games_Quest_Versions1_idx', '{{%games}}');
        $this->dropTable('{{%games}}');
    }
}
