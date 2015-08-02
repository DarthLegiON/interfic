<?php

namespace app\modules\editor\controllers;

use app\modules\editor\models\VersionCreateForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use app\modules\base\models\Quest;
use app\modules\base\models\QuestVersion;
use app\modules\editor\models\QuestCreateForm;

class VersionsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['open', 'delete', 'create'],
                        'allow' => true,
                        'roles' => ['createQuest', 'manageQuests'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreate($id)
    {
        $model = new VersionCreateForm;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                /** @var QuestVersion $version */
                $version = QuestVersion::findOne(['id_Quest_Version' => $model->startVersion]);
                $version->cloneVersion($model);

                return $this->redirect(['quest/view', 'id' => $id]);

                /*$quest = new Quest([
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
                return $this->redirect(['index']);*/
            }
        } else {

            $versionsList = Quest::findOne(['id_quest' => $id])->getVersionsShortList();

            return $this->render('create', [
                'model' => $model,
                'versionsList' => $versionsList,
            ]);
        }
    }

    public function actionOpen($id)
    {

    }

    public function actionDelete($id)
    {

    }
}
