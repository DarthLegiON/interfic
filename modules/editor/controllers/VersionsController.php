<?php

namespace app\modules\editor\controllers;

use app\modules\editor\models\VersionCreateForm;
use app\modules\editor\models\VersionEditForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use app\modules\base\models\Quest;
use app\modules\base\models\QuestVersion;
use app\modules\editor\models\QuestCreateForm;
use yii\web\ForbiddenHttpException;

class VersionsController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['open', 'delete', 'create', 'make-test', 'make-production'],
                        'allow' => true,
                        'roles' => ['createQuest', 'manageQuests'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Отображает страницу создания новой версии
     * @param int $id ID квеста
     * @param int|null $id_start ID стартового квеста
     * @return string|\yii\web\Response
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
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
        /** @var QuestVersion $version */
        $version = QuestVersion::findOne(['id_Quest_Version' => $id]);
        if ($this->checkAccess($version)) {
            $form = new VersionEditForm;
            if ($form->load(Yii::$app->request->post())) {
                $version->name = $form->questName;
                $version->description = $form->description;
                $version->version_name = $form->versionName;
                $version->save_date = (new \DateTime('now'))->format('Y-m-d H:i:s');
                $version->save();
            } else {
                $form->loadFromRecord($version);
            }
            return $this->render('open', [
                'version' => $version,
                'versionForm' => $form,
            ]);
        }
    }

    /**
     * Безвозвратно удаляет версию из системы
     * @param int $id ID версии
     * @return string
     * @throws \Exception
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete($id)
    {
        /** @var QuestVersion $version */
        $version = QuestVersion::findOne(['id_Quest_Version' => $id]);
        if ($this->checkAccess($version)) {
            if (empty($version->testProduction)) {
                $version->delete();
                // TODO сделать каскадное удаление всех элементов версии
                $this->redirect(['quest/view', 'id' => $version->fid_quest]);
            } else {
                return $this->render('cant-delete', [
                    'model' => $version,
                ]);
            }
        }
    }

    /**
     * Делает версию тестовой.
     * @param int $id ID версии
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionMakeTest($id)
    {
        /** @var QuestVersion $version */
        $version = QuestVersion::findOne(['id_Quest_Version' => $id]);
        if ($this->checkAccess($version)) {
            $version->setTest();
            $this->redirect(['quest/view', 'id' => $version->fid_quest]);
        }
    }

    /**
     * Делает версию рабочей.
     * @param int $id ID версии
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionMakeProduction($id)
    {
        /** @var QuestVersion $version */
        $version = QuestVersion::findOne(['id_Quest_Version' => $id]);
        if ($this->checkAccess($version)) {
            $version->setProduction();
            $this->redirect(['quest/view', 'id' => $version->fid_quest]);
        }
    }
}
