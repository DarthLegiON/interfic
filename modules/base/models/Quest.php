<?php

namespace app\modules\base\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "Quests".
 *
 * @property integer $id_quest
 * @property integer $fid_production_version
 * @property integer $fid_test_version
 * @property integer $fid_creator_user
 * @property integer $name
 * @property integer $description
 * @property integer $versionCode
 * @property integer $creatorUsername
 */
class Quest extends \yii\db\ActiveRecord
{
    /**
     * @var QuestVersion Актуальная версия (test или production), кэшируется
     */
    private $actualVersion;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Quests';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fid_production_version', 'fid_test_version', 'fid_creator_user'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_quest' => 'Идентификатор',
            'fid_production_version' => 'Окончательная версия',
            'fid_test_version' => 'Тестовая версия',
            'fid_creator_user' => 'Автор',
            'name' => 'Название',
            'description' => 'Описание',
            'versionCode' => 'Версия',
            'creatorUsername' => 'Автор',
        ];
    }

    /**
     * Возвращает актуальную версию (релиз или последнюю тестовую)
     * @return QuestVersion
     */
    private function getActualVersion()
    {
        if (!isset($this->actualVersion)) {
            $field = isset($this->fid_production_version) ? 'fid_production_version' : 'fid_test_version';
            $this->actualVersion = $this->hasOne(QuestVersion::className(), ['id_Quest_Version' => $field])->all()[0];
        }
        return $this->actualVersion;
    }

    /**
     * Возвращает имя квеста (по актуальной версии)
     * @return string
     */
    public function getName()
    {
        return $this->getActualVersion()->name;
    }

    /**
     * Возвращает описание квеста (по актуальной версии)
     * @return string
     */
    public function getDescription()
    {
        return $this->getActualVersion()->description;
    }

    /**
     * Возвращает код актуальной версии квеста в формате релиз.итерация
     * @return string
     */
    public function getVersionCode()
    {
        return $this->getActualVersion()->release . '.' . $this->getActualVersion()->iteration;
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

    /**
     * Получает все квесты
     * @return ActiveDataProvider
     */
    public static function searchAll()
    {
        $query = self::find();

        if (!Yii::$app->user->can('manageQuests')) {
            $query->where(['fid_creator_user' => Yii::$app->user->id])
                ->orWhere('fid_production_version is not null');
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

    }
}
