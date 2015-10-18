<?php

namespace app\modules\base\models;

use app\modules\base\models\interfaces\Restricted;
use app\modules\editor\models\VersionCreateForm;
use DateTimeZone;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\Expression;

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
 * @property integer $fid_start_version
 * @property boolean isTest
 * @property boolean isProduction
 * @property string startVersionCode
 * @property string creatorUsername
 * @property Parameter[] parameters
 * @property integer parametersCount
 */
class QuestVersion extends \yii\db\ActiveRecord implements Restricted
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%quest_versions}}';
    }

    public static function findByQuestId($id)
    {
        $query = self::find()
            ->where(['fid_quest' => $id])
            ->orderBy(['id_Quest_Version' => SORT_DESC]);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'save_date',
                'updatedAtAttribute' => 'save_date',
                'value' => function () {
                    return date('Y-m-d H:i:s');
                }
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fid_quest', 'name', 'save_date', 'fid_creator_user'], 'required'],
            [['fid_quest', 'release', 'iteration', 'fid_creator_user', 'fid_start_version'], 'integer'],
            [['save_date'], 'safe'],
            [['name'], 'string', 'max' => 256],
            [['description'], 'string', 'max' => 1000],
            [['version_name'], 'string', 'max' => 150],
            [['fid_start_version'], 'exist', 'skipOnError' => true, 'targetClass' => QuestVersion::className(), 'targetAttribute' => ['fid_start_version' => 'id_Quest_Version']],
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
            'fid_start_version' => 'Предыдущая версия',
            'startVersionCode' => 'Предыдущая версия',
        ];
    }

    public function getVersionCode()
    {
        return $this->release . '.' . $this->iteration;
    }

    public function getTestProduction()
    {
        $result = [];
        if ($this->getIsTest()) {
            $result[] = 'Тестовая';
        }
        if ($this->getIsProduction()) {
            $result[] = 'Рабочая';
        }
        return implode(', ', $result);
    }

    public function getIsTest()
    {
        return count(Quest::findAll(['fid_test_version' => $this->id_Quest_Version])) > 0;
    }

    public function getIsProduction()
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

    public function getParameters()
    {
        return $this->hasMany(Parameter::className(), ['fid_quest' => 'id_Quest_Version']);
    }

    public function getParametersCount()
    {
        return count($this->parameters);
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
        $newVersion->fid_creator_user = Yii::$app->user->id;
        $newVersion->fid_start_version = $this->id_Quest_Version;
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

    /**
     * Находит предыдущую версию.
     * @return null|QuestVersion
     */
    public function getStartVersion()
    {
        return self::findOne(['id_Quest_Version' => $this->fid_start_version]);
    }

    /**
     * Находит код предыдущей версии.
     * @return null|QuestVersion
     */
    public function getStartVersionCode()
    {
        $version = $this->getStartVersion();
        if ($version !== null) {
            return $version->versionCode;
        } else {
            return null;
        }
    }

    /**
     * @inheritDoc
     */
    public function beforeDelete()
    {
        $this->transferStartVersion();

        return parent::beforeDelete();
    }

    /**
     *
     * Проверяет все версии, которые были от данной порождены, и привязывает к ним стартовую версию данной версии.
     * @throws \yii\db\Exception
     */
    public function transferStartVersion()
    {
        $followedVersions = self::findAll(['fid_start_version' => $this->id_Quest_Version]);

        if (count($followedVersions) > 0) {
            $transaction = $this->getDb()->beginTransaction();

            foreach ($followedVersions as $version) {
                $version->fid_start_version = $this->fid_start_version;
                $version->save();
            }

            $transaction->commit();
        }
    }
}
