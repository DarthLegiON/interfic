<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "Enum_Values".
 *
 * @property integer $id_Enumeration
 * @property string $text
 * @property integer $fid_parameter
 * @property integer $number_value
 *
 * @property Parameter $fidParameter
 */
class EnumValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Enum_Values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fid_parameter'], 'required'],
            [['fid_parameter', 'number_value'], 'integer'],
            [['text'], 'string', 'max' => 100],
            [['fid_parameter'], 'exist', 'skipOnError' => true, 'targetClass' => Parameter::className(), 'targetAttribute' => ['fid_parameter' => 'id_Parameter']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_Enumeration' => 'Id  Enumeration',
            'text' => 'Text',
            'fid_parameter' => 'Fid Parameter',
            'number_value' => 'Number Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFidParameter()
    {
        return $this->hasOne(Parameter::className(), ['id_Parameter' => 'fid_parameter']);
    }
}
