<?php

use yii\db\Migration;
use yii\db\Schema;

class m151018_141338_fix_user_ip extends Migration
{
    public function up()
    {
        $this->alterColumn(\app\modules\base\models\User::tableName(), 'ip_address', Schema::TYPE_STRING . '(15)');
    }

    public function down()
    {
        echo "m151018_141338_fix_user_ip cannot be reverted.\n";

        return true;
    }
}
