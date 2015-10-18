<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "Parameters_Types".
 *
 * @property integer $id_ParameterType
 * @property string $name
 * @property string $class_name
 *
 * @property Parameter[] $parameters
 */
class ParameterType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%parameters_types}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 100],
            [['class_name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_ParameterType' => 'Id',
            'name' => 'Название',
            'class_name' => 'Класс',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParameters()
    {
        return $this->hasMany(Parameter::className(), ['fid_type' => 'id_ParameterType']);
    }
}
