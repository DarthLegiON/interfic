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

class VersionsController extends BaseController
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

    public function actionCreate($id, $id_start = null)
    {
        /** @var Quest $quest */
        $quest = Quest::findOne(['id_quest' => $id]);
        if ($this->checkAccess($quest)) {
            $model = new VersionCreateForm;
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    /** @var QuestVersion $version */
                    $version = QuestVersion::findOne(['id_Quest_Version' => $model->startVersion]);
                    $version->cloneVersion($model);

                    return $this->redirect(['quest/view', 'id' => $id]);
                }
            } else {

                $versionsList = $quest->getVersionsShortList();
                $model->startVersion = $id_start;

                return $this->render('create', [
                    'model' => $model,
                    'versionsList' => $versionsList,
                ]);
            }
        }
    }

    public function actionOpen($id)
    {

    }

    public function actionDelete($id)
    {
        /** @var QuestVersion $version */
        $version = QuestVersion::findOne(['id_Quest_Version' => $id]);
        if ($this->checkAccess($version)) {
            if (empty($version->testProduction)) {
                $version->delete();
                $this->redirect(['quest/view', 'id' => $version->fid_quest]);
            } else {
                return $this->render('cant-delete', [
                    'model' => $version,
                ]);
            }
        }
    }
}
