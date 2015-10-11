<?php
/**
 * Created by PhpStorm.
 * User: Darth LegiON
 * Date: 02.08.2015
 * Time: 14:54
 */

namespace app\modules\editor\models;


use app\modules\base\models\Quest;
use yii\base\Model;

class VersionCreateForm extends Model
{
    public $versionName;
    public $startVersion;
    public $isTest;
    public $isNewRelease;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['versionName', 'startVersion'], 'required'],
            [['versionName'], 'string', 'max' => 150],
            [['isTest', 'isNewRelease'], 'boolean'],
            [['startVersion'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'versionName' => 'Название',
            'startVersion' => 'Стартовая версия',
            'isTest' => 'Сделать тестовой',
            'isNewRelease' => 'Выпустить',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'versionName' => 'Выберите название, наиболее точно отражающее, что вы собираетесь делать в этой версии.',
            'startVersion' => 'Выберите версию, которую нужно скопировать в новую',
            'isTest' => 'Если выбрать эту опцию, новая версия станет тестовой',
            'isNewRelease' => 'Если выбрать эту опцию, новый релиз начнется этой версией, номер релиза будет увеличен на 1',
        ];
    }
}