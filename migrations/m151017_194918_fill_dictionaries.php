<?php

use yii\db\Migration;

class m151017_194918_fill_dictionaries extends Migration
{
    private $parametersTypes = [
        ['Числовой', 'IntegerParameter'],
        ['Строковый', 'StringParameter'],
        ['Перечисление', 'EnumParameter'],
        ['Дата-время', 'DateTimeParameter'],
    ];

    public function up()
    {
        $this->batchInsert(\app\modules\base\models\ParameterType::tableName(), ['name', 'class_name'], $this->parametersTypes);
    }

    public function down()
    {
        $this->delete(\app\modules\base\models\ParameterType::tableName(),
            ['in', 'class_name', [
                'IntegerParameter',
                'StringParameter',
                'EnumParameter',
                'DateTimeParameter',
            ]
            ]);

        return true;
    }
}
