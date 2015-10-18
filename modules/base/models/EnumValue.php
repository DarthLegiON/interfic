<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "Enum_Values".
 *
 * @property integer $id_Enumeration
 * @property string $text
 * @property integer $parameter
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
        return '{{%enum_values}}';
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
            'id_Enumeration' => 'Id',
            'text' => 'Подпись',
            'fid_parameter' => 'Параметр',
            'parameter' => 'Параметр',
            'number_value' => 'Числовое значение',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParameter()
    {
        return $this->hasOne(Parameter::className(), ['id_Parameter' => 'fid_parameter']);
    }
}
