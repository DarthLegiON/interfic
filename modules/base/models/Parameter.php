<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "Parameters".
 *
 * @property integer $id_Parameter
 * @property string $name
 * @property string $default_value
 * @property integer $fid_type
 * @property integer $fid_quest
 *
 * @property EnumValue[] $enumValues
 * @property ParameterType $fidType
 * @property QuestVersion $fidQuest
 * @property ParameterValue[] $parametersValues
 */
class Parameter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Parameters';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fid_type', 'fid_quest'], 'required'],
            [['fid_type', 'fid_quest'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['default_value'], 'string', 'max' => 5000],
            [['fid_type'], 'exist', 'skipOnError' => true, 'targetClass' => ParameterType::className(), 'targetAttribute' => ['fid_type' => 'id_ParameterType']],
            [['fid_quest'], 'exist', 'skipOnError' => true, 'targetClass' => QuestVersion::className(), 'targetAttribute' => ['fid_quest' => 'id_Quest_Version']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_Parameter' => 'Id  Parameter',
            'name' => 'Name',
            'default_value' => 'Default Value',
            'fid_type' => 'Fid Type',
            'fid_quest' => 'Fid Quest',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnumValues()
    {
        return $this->hasMany(EnumValue::className(), ['fid_parameter' => 'id_Parameter']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ParameterType::className(), ['id_ParameterType' => 'fid_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuest()
    {
        return $this->hasOne(QuestVersion::className(), ['id_Quest_Version' => 'fid_quest']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParametersValues()
    {
        return $this->hasMany(ParametersValues::className(), ['fid_Parameter' => 'id_Parameter']);
    }
}
