<?php
/**
 * Created by PhpStorm.
 * User: Darth LegiON
 * Date: 11.08.2015
 * Time: 21:43
 */

namespace app\modules\editor\models;


use app\modules\base\models\QuestVersion;
use yii\base\Model;

class VersionEditForm extends Model
{
    public $versionName;
    public $questName;
    public $description;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['versionName', 'questName'], 'required'],
            [['versionName', 'questName'], 'string', 'max' => 150],
            [['description'], 'string', 'max' => 1000],
            [['startVersion'], 'integer'],
        ];


    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'versionName' => 'Название версии',
            'questName' => 'Название квеста',
            'description' => 'Описание текста',
        ];
    }

    /**
     * Создает экземпляр формы из модели версии
     * @param QuestVersion $record
     * @return static
     */
    public function loadFromRecord(QuestVersion $record)
    {
        $this->versionName = $record->version_name;
        $this->questName = $record->name;
        $this->description = $record->description;
    }
}