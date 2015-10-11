<?php

namespace app\modules\editor\controllers;

use Yii;
use yii\filters\AccessControl;
use app\modules\base\models\Quest;
use app\modules\base\models\QuestVersion;
use app\modules\editor\models\QuestCreateForm;

class QuestController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['quest-create', 'index', 'view'],
                        'allow' => true,
                        'roles' => ['createQuest', 'manageQuests'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = Quest::searchAll();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionQuestCreate()
    {
        $model = new QuestCreateForm;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $quest = new Quest([
                    'fid_creator_user' => Yii::$app->user->id,
                ]);
                $quest->save();

                $questVersion = new QuestVersion([
                    'fid_quest' => $quest->id_quest,
                    'name' => $model->name,
                    'description' => $model->description,
                    'save_date' => (new \DateTime('now'))->format('Y-m-d H:i:s'),
                    'fid_creator_user' => Yii::$app->user->id,
                    'version_name' => 'Начальная версия',
                ]);
                $questVersion->save();
                $quest->fid_test_version = $questVersion->id_Quest_Version;
                $quest->save();
                return $this->redirect(['index']);
            }
        } else {

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionView($id)
    {
        /** @var Quest $quest */
        $quest = Quest::findOne(['id_quest' => $id]);
        if ($this->checkAccess($quest)) {

            $versions = QuestVersion::findByQuestId($id);

            return $this->render('view', [
                'quest' => $quest,
                'versions' => $versions,
            ]);
        }

    }
}
