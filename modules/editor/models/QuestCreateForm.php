<?php
/**
 * Created by PhpStorm.
 * User: Darth LegiON
 * Date: 17.06.2015
 * Time: 0:50
 */

namespace app\modules\editor\models;

use yii\base\Model;

class QuestCreateForm extends Model
{
    public $name;
    public $description;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'description'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'name' => 'Выберите название, наиболее точно отражающее смысл игры',
            'description' => 'Опишите события, происходящие в игре',
        ];
    }

}