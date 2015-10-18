<?php
/**
 * Created by PhpStorm.
 * User: Darth LegiON
 * Date: 16.08.2015
 * Time: 21:04
 */

namespace app\modules\editor\models;


use app\modules\base\models\Parameter;
use app\modules\base\models\QuestVersion;
use yii\base\Model;
use yii\db\Query;
use yii\validators\RegularExpressionValidator;

/**
 * Форма редактирования параметра
 * @property QuestVersion $quest
 * @package app\modules\editor\models
 */
class ParameterEditForm extends Model
{
    public $id_parameter;
    public $name;
    public $code;
    public $type;
    public $defaultValue;
    public $fid_quest;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'code', 'type', 'fid_quest'], 'required'],
            [['id_parameter', 'fid_quest'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['code'], 'string', 'max' => 50],
            [['code'], 'match', 'pattern' => '/^[a-zA-Z\_][a-zA-Z\_\d]*$/'],
            [['defaultValue'], 'string', 'max' => 5000],
            [['code'], 'checkUniqueCode'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'code' => 'Код',
            'type' => 'Тип',
            'defaultValue' => 'По умолчанию',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'code' => 'Код параметра: латиница, знак подчеркивания и цифры, не может начинаться с цифры (например, "hp1")',
            'defaultValue' => 'Значение, которое имеет параметр при старте квеста',
        ];
    }

    /**
     * Загружает экземпляр формы из модели
     * @param Parameter $record
     */
    public function loadFromRecord(Parameter $record)
    {
        $this->id_parameter = $record->id_Parameter;
        $this->name = $record->name;
        $this->code = $record->code;
        $this->type = $record->fid_type;
        $this->defaultValue = $record->default_value;
        $this->fid_quest = $record->fid_quest;
    }

    /**
     * Проверяет код на уникальность
     */
    public function checkUniqueCode()
    {
        $query = Parameter::find()
            ->where(['code' => $this->code])
            ->andWhere(['fid_quest' => $this->fid_quest])
            ->andWhere(['not', ['id_Parameter' => $this->id_parameter]]);
        if (count($query->all()) > 0) {
            $this->addError('code', 'Код должен быть уникальным для данного квеста');
        }
    }

    /**
     * @return QuestVersion
     */
    public function getQuest()
    {
        return QuestVersion::findOne($this->fid_quest);
    }

}