<?php

namespace app\modules\base\models;

use app\modules\base\models\interfaces\Restricted;
use app\modules\editor\models\VersionCreateForm;
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
 * @property string $testProduction
 */
class QuestVersion extends \yii\db\ActiveRecord implements Restricted
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Quest_Versions';
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
            'save_date' => 'Дата сохранения',
            'versionCode' => 'Код',
            'testProduction' => '',
            'fid_creator_user' => 'Автор',
            'creatorUsername' => 'Автор',
        ];
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

    private function checkTest()
    {
        return count(Quest::findAll(['fid_test_version' => $this->id_Quest_Version])) > 0;
    }

    private function checkProduction()
    {
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

    /**
     * Создает точную копию версии вместе со всеми настройками квеста (каскадно)
     * @param VersionCreateForm $form
     * @return QuestVersion
     */
    public function cloneVersion($form)
    {
        $newVersion = new QuestVersion;
        $newVersion->attributes = $this->attributes;
        $newVersion->id_Quest_Version = null;
        $newVersion->version_name = $form->versionName;
        $newVersion->save_date = (new \DateTime('now'))->format('Y-m-d H:i:s');
        $newVersion->save();

        if ($form->isTest) {
            $newVersion->setTest();
        }

        if ($form->isNewRelease) {
            $newVersion->release = $this->getMaxRelease() + 1;
            $newVersion->iteration = 0;
            $newVersion->setProduction();
        } else {
            $newVersion->iteration = $this->getMaxIteration() + 1;
        }

        $newVersion->save();

        // TODO добавить каскадное клонирование всех параметров квеста
        return $newVersion;
    }

    /**
     * Помечает версию как тестовую
     */
    public function setTest()
    {
        /** @var Quest $quest */
        $quest = Quest::findOne(['id_quest' => $this->fid_quest]);
        $quest->fid_test_version = $this->id_Quest_Version;
        $quest->save();
    }

    /**
     * Находит максимальную версию релиза
     * @return integer
     */
    private function getMaxRelease()
    {
        $releaseVersions = QuestVersion::find()->where(['fid_quest' => $this->fid_quest])->orderBy(['release' => SORT_DESC])->all();
        return $releaseVersions[0]->release;
    }

    /**
     * Помечает версию как рабочую
     */
    public function setProduction()
    {
        /** @var Quest $quest */
        $quest = Quest::findOne(['id_quest' => $this->fid_quest]);
        $quest->fid_production_version = $this->id_Quest_Version;
        $quest->save();
    }

    /**
     * Находит максимальную итерацию версии
     * @return integer
     */
    private function getMaxIteration()
    {
        $releaseVersions = QuestVersion::find()->where(['fid_quest' => $this->fid_quest, 'release' => $this->release])->orderBy(['iteration' => SORT_DESC])->all();
        return $releaseVersions[0]->iteration;
    }

    /**
     * @inheritdoc
     */
    public function checkPermission()
    {
        return Yii::$app->user->can('manageQuests')
        || Yii::$app->user->id == $this->fid_creator_user
        || Yii::$app->user->id == Quest::findOne(['id_quest' => $this->fid_quest])->fid_creator_user;
    }
}
