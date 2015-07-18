<?php

namespace app\modules\base\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "Quest_Versions".
 *
 * @property integer $id_Quest_Version
 * @property integer $fid_quest
 * @property string $name
 * @property string $description
 * @property integer $release
 * @property integer $iteration
 * @property string $save_date
 */
class QuestVersion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Quest_Versions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fid_quest', 'name', 'save_date'], 'required'],
            [['fid_quest', 'release', 'iteration'], 'integer'],
            [['save_date'], 'safe'],
            [['name'], 'string', 'max' => 256],
            [['description'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_Quest_Version' => 'Id  Quest  Version',
            'fid_quest' => 'Fid Quest',
            'name' => 'Название',
            'description' => 'Описание',
            'release' => 'Версия релиза',
            'iteration' => 'Номер итерации',
            'save_date' => 'Дата сохранения версии',
            'versionCode' => 'Версия',
        ];
    }

    public static function findByQuestId($id)
    {
        $query = self::find()
            ->where(['fid_quest' => $id])
            ->orderBy(['save_date' => SORT_DESC]);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

    }
}
