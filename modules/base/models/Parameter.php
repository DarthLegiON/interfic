<?php

namespace app\modules\base\models;

use app\modules\base\models\interfaces\Restricted;
use app\modules\editor\models\ParameterEditForm;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "Parameters".
 *
 * @property integer $id_Parameter
 * @property string $name
 * @property string $default_value
 * @property integer $fid_type
 * @property integer $fid_quest
 * @property string $code
 *
 * @property EnumValue[] $enumValues
 * @property ParameterType $type
 * @property QuestVersion $quest
 * @property mixed canDelete
 */
class Parameter extends \yii\db\ActiveRecord implements Restricted
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Parameters';
    }

    /**
     * @param integer $versionId
     * @return ActiveDataProvider
     */
    public static function findByVersionId($versionId)
    {
        $query = static::find()
            ->where(['fid_quest' => $versionId]);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fid_type', 'fid_quest', 'code'], 'required'],
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
            'id_Parameter' => 'Id',
            'name' => 'Название',
            'default_value' => 'По умолчанию',
            'fid_type' => 'Тип',
            'type' => 'Тип',
            'fid_quest' => 'Квест',
            'quest' => 'Квест',
            'code' => 'Код',
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
    /*public function getParametersValues()
    {
        return $this->hasMany(ParameterValues::className(), ['fid_Parameter' => 'id_Parameter']);
    }*/
    /**
     * Проверяет, есть ли у пользователя доступ к записи
     * @return bool
     */
    public function checkPermission()
    {
        return $this->quest->checkPermission();
    }

    public function loadFromForm(ParameterEditForm $form)
    {
        $this->name = $form->name;
        $this->default_value = $form->defaultValue;
        $this->fid_type = $form->type;
        $this->fid_quest = $form->fid_quest;
        $this->code = $form->code;
    }

    public function getCanDelete()
    {
        return !$this->quest->isProduction;
    }
}
