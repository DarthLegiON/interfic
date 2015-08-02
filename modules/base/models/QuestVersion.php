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
 * @property string versionCode
 * @property integer $fid_creator_user
 * @property string $version_name
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
            [['fid_quest', 'name', 'save_date', 'fid_creator_user'], 'required'],
            [['fid_quest', 'release', 'iteration', 'fid_creator_user'], 'integer'],
            [['save_date'], 'safe'],
            [['name'], 'string', 'max' => 256],
            [['description'], 'string', 'max' => 1000],
            [['version_name'], 'string', 'max' => 150],
            [['fid_creator_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['fid_creator_user' => 'id_User']],
            [['fid_quest'], 'exist', 'skipOnError' => true, 'targetClass' => Quest::className(), 'targetAttribute' => ['fid_quest' => 'id_quest']],
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
            'version_name' => 'Название',
            'description' => 'Описание',
            'release' => 'Версия релиза',
            'iteration' => 'Номер итерации',
            'save_date' => 'Дата сохранения версии',
            'versionCode' => 'Версия',
            'testProduction' => '',
            'fid_creator_user' => 'Автор версии',
            'creatorUsername' => 'Автор версии',
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

    public function getVersionCode()
    {
        return $this->release . '.' . $this->iteration;
    }

    public function getTestProduction()
    {
        $result = [];
        if ($this->checkTest()) {
            $result[] = 'Тестовая';
        }
        if ($this->checkProduction()) {
            $result[] = 'Рабочая';
        }
        return implode(', ', $result);
    }

    private function checkTest(){
        return count(Quest::findAll(['fid_test_version' => $this->id_Quest_Version])) > 0;
    }

    private function checkProduction(){
        return count(Quest::findAll(['fid_production_version' => $this->id_Quest_Version])) > 0;
    }

    public function getCreatorUsername()
    {
        /** @var User $model */
        $model = $this->hasOne(User::className(), ['id_User' => 'fid_creator_user'])->all()[0];
        if (isset($model)) {
            return $model->login;
        } else {
            return null;
        }

    }
}
