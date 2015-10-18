<?php

use yii\db\Migration;

class m151017_131030_Relations extends Migration
{
    public function safeUp()
    {
        $this->addForeignKey('fk_Actions_fid_quest', '{{%actions}}', 'fid_quest', '{{%quest_versions}}', 'id_Quest_Version');
        $this->addForeignKey('fk_Answers_fid_quest', '{{%answers}}', 'fid_quest', '{{%quest_versions}}', 'id_Quest_Version');
        $this->addForeignKey('fk_Answers_fid_action', '{{%answers}}', 'fid_action', '{{%actions}}', 'id_Action');
        $this->addForeignKey('fk_Constants_fid_quest', '{{%constants}}', 'fid_quest', '{{%quest_versions}}', 'id_Quest_Version');
        $this->addForeignKey('fk_Constants_fid_action', '{{%constants}}', 'fid_action', '{{%actions}}', 'id_Action');
        $this->addForeignKey('fk_Enum_Values_fid_parameter', '{{%enum_values}}', 'fid_parameter', '{{%parameters}}', 'id_Parameter');
        $this->addForeignKey('fk_Game_Instances_fid_user', '{{%game_instances}}', 'fid_user', '{{%users}}', 'id_User');
        $this->addForeignKey('fk_Game_Instances_fid_game', '{{%game_instances}}', 'fid_game', '{{%games}}', 'id_game');
        $this->addForeignKey('fk_Gameplay_States_fid_game_instance', '{{%gameplay_states}}', 'fid_game_instance', '{{%game_instances}}', 'id_game_instance');
        $this->addForeignKey('fk_Gameplay_States_fid_Stage', '{{%gameplay_states}}', 'fid_Stage', '{{%stages}}', 'id_Stage');
        $this->addForeignKey('fk_Games_fid_quest', '{{%games}}', 'fid_quest', '{{%quest_versions}}', 'id_Quest_Version');
        $this->addForeignKey('fk_Parameters_fid_type', '{{%parameters}}', 'fid_type', '{{%parameters_types}}', 'id_ParameterType');
        $this->addForeignKey('fk_Parameters_fid_quest', '{{%parameters}}', 'fid_quest', '{{%quest_versions}}', 'id_Quest_Version');
        $this->addForeignKey('fk_Parameters_Values_fid_Gameplay_State', '{{%parameters_values}}', 'fid_Gameplay_State', '{{%gameplay_states}}', 'id_Gameplay_State');
        $this->addForeignKey('fk_Parameters_Values_fid_Parameter', '{{%parameters_values}}', 'fid_Parameter', '{{%parameters}}', 'id_Parameter');
        $this->addForeignKey('fk_Quest_Versions_fid_quest', '{{%quest_versions}}', 'fid_quest', '{{%quests}}', 'id_quest');
        $this->addForeignKey('fk_Quest_Versions_fid_creator_user', '{{%quest_versions}}', 'fid_creator_user', '{{%users}}', 'id_User');
        $this->addForeignKey('fk_Quest_Versions_fid_start_version', '{{%quest_versions}}', 'fid_start_version', '{{%quest_versions}}', 'id_Quest_Version');
        $this->addForeignKey('fk_Quests_fid_production_version', '{{%quests}}', 'fid_production_version', '{{%quest_versions}}', 'id_Quest_Version');
        $this->addForeignKey('fk_Quests_fid_creator_user', '{{%quests}}', 'fid_creator_user', '{{%users}}', 'id_User');
        $this->addForeignKey('fk_Quests_fid_test_version', '{{%quests}}', 'fid_test_version', '{{%quest_versions}}', 'id_Quest_Version');
        $this->addForeignKey('fk_Rel_Stages_Answers_fid_answer', '{{%rel_stages_answers}}', 'fid_answer', '{{%answers}}', 'id_Answer');
        $this->addForeignKey('fk_Rel_Stages_Answers_fid_stage', '{{%rel_stages_answers}}', 'fid_stage', '{{%stages}}', 'id_Stage');
        $this->addForeignKey('fk_Rel_Stages_Templates_fid_stage', '{{%rel_stages_templates}}', 'fid_stage', '{{%stages}}', 'id_Stage');
        $this->addForeignKey('fk_Rel_Stages_Templates_fid_template', '{{%rel_stages_templates}}', 'fid_template', '{{%templates}}', 'id_template');
        $this->addForeignKey('fk_Stages_fid_quest_version', '{{%stages}}', 'fid_quest_version', '{{%quest_versions}}', 'id_Quest_Version');
        $this->addForeignKey('fk_Stages_fid_params_template', '{{%stages}}', 'fid_params_template', '{{%templates}}', 'id_template');
        $this->addForeignKey('fk_Stages_fid_after_action', '{{%stages}}', 'fid_after_action', '{{%actions}}', 'id_Action');
        $this->addForeignKey('fk_Stages_fid_before_action', '{{%stages}}', 'fid_before_action', '{{%actions}}', 'id_Action');
        $this->addForeignKey('fk_Stages_fid_picture', '{{%stages}}', 'fid_picture', '{{%pictures}}', 'id_Picture');
        $this->addForeignKey('fk_Template_Variables_fid_template', '{{%template_variables}}', 'fid_template', '{{%templates}}', 'id_template');
        $this->addForeignKey('fk_Templates_fid_quest_version', '{{%templates}}', 'fid_quest_version', '{{%quest_versions}}', 'id_Quest_Version');
    }

    public function safeDown()
    {

        $this->dropForeignKey('fk_Actions_fid_quest', '{{%actions}}');
        $this->dropForeignKey('fk_Answers_fid_quest', '{{%answers}}');
        $this->dropForeignKey('fk_Answers_fid_action', '{{%answers}}');
        $this->dropForeignKey('fk_Constants_fid_quest', '{{%constants}}');
        $this->dropForeignKey('fk_Constants_fid_action', '{{%constants}}');
        $this->dropForeignKey('fk_Enum_Values_fid_parameter', '{{%enum_values}}');
        $this->dropForeignKey('fk_Game_Instances_fid_user', '{{%game_instances}}');
        $this->dropForeignKey('fk_Game_Instances_fid_game', '{{%game_instances}}');
        $this->dropForeignKey('fk_Gameplay_States_fid_game_instance', '{{%gameplay_states}}');
        $this->dropForeignKey('fk_Gameplay_States_fid_Stage', '{{%gameplay_states}}');
        $this->dropForeignKey('fk_Games_fid_quest', '{{%games}}');
        $this->dropForeignKey('fk_Parameters_fid_type', '{{%parameters}}');
        $this->dropForeignKey('fk_Parameters_fid_quest', '{{%parameters}}');
        $this->dropForeignKey('fk_Parameters_Values_fid_Gameplay_State', '{{%parameters_values}}');
        $this->dropForeignKey('fk_Parameters_Values_fid_Parameter', '{{%parameters_values}}');
        $this->dropForeignKey('fk_Quest_Versions_fid_quest', '{{%quest_versions}}');
        $this->dropForeignKey('fk_Quest_Versions_fid_creator_user', '{{%quest_versions}}');
        $this->dropForeignKey('fk_Quest_Versions_fid_start_version', '{{%quest_versions}}');
        $this->dropForeignKey('fk_Quests_fid_production_version', '{{%quests}}');
        $this->dropForeignKey('fk_Quests_fid_creator_user', '{{%quests}}');
        $this->dropForeignKey('fk_Quests_fid_test_version', '{{%quests}}');
        $this->dropForeignKey('fk_Rel_Stages_Answers_fid_answer', '{{%rel_stages_answers}}');
        $this->dropForeignKey('fk_Rel_Stages_Answers_fid_stage', '{{%rel_stages_answers}}');
        $this->dropForeignKey('fk_Rel_Stages_Templates_fid_stage', '{{%rel_stages_templates}}');
        $this->dropForeignKey('fk_Rel_Stages_Templates_fid_template', '{{%rel_stages_templates}}');
        $this->dropForeignKey('fk_Stages_fid_quest_version', '{{%stages}}');
        $this->dropForeignKey('fk_Stages_fid_params_template', '{{%stages}}');
        $this->dropForeignKey('fk_Stages_fid_after_action', '{{%stages}}');
        $this->dropForeignKey('fk_Stages_fid_before_action', '{{%stages}}');
        $this->dropForeignKey('fk_Stages_fid_picture', '{{%stages}}');
        $this->dropForeignKey('fk_Template_Variables_fid_template', '{{%template_variables}}');
        $this->dropForeignKey('fk_Templates_fid_quest_version', '{{%templates}}');

    }
}
