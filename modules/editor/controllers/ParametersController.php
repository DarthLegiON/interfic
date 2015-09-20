<?php

namespace app\modules\editor\controllers;

use Yii;
use app\modules\editor\models\ParameterEditForm;
use app\modules\base\models\Parameter;
use app\modules\base\models\ParameterType;
use app\modules\base\models\QuestVersion;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class ParametersController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['createQuest', 'manageQuests'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($id_version)
    {
        /** @var QuestVersion $version */
        $version = QuestVersion::findOne(['id_Quest_Version' => $id_version]);

        if ($this->checkAccess($version)) {

            $parameters = Parameter::findByVersionId($id_version);

            return $this->render('index', [
                'version' => $version,
                'parameters' => $parameters,
            ]);
        }

    }

    /**
     * Отображает страницу создания нового параметра
     * @param int $id_version ID версии
     * @param int|null $id_current ID параметра, который нужно продублировать
     * @return string|\yii\web\Response|null
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionCreate($id_version, $id_current = null)
    {
        /** @var QuestVersion $version */
        $version = QuestVersion::findOne(['id_Quest_Version' => $id_version]);
        if ($this->checkAccess($version)) {
            $model = new ParameterEditForm;
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {

                    $parameter = new Parameter();
                    $parameter->loadFromForm($model);
                    /** @var QuestVersion $newVersion */
                    $newVersion = QuestVersion::findOne(['id_Quest_Version' => $model->fid_quest]);
                    if ($this->checkAccess($newVersion)) {
                        $parameter->save();

                        return $this->redirect(['index', 'id_version' => $id_version]);
                    }
                } else {
                    return $this->render('edit', [
                        'model' => $model,
                        'types' => ParameterType::find()->all(),
                    ]);
                }
            } else {

                if (isset($id_current)) {
                    /** @var Parameter $current */
                    $current = Parameter::findOne(['id_Parameter' => $id_current]);
                    if ($this->checkAccess($current)) {
                        $model->loadFromRecord($current);
                        $model->id_parameter = null;
                    }
                } else {
                    $model->fid_quest = $id_version;
                }

                return $this->render('edit', [
                    'model' => $model,
                    'types' => ParameterType::find()->all(),
                ]);
            }
        }
    }

    /**
     * Отображает страницу редактирования параметра
     * @param int $id ID параметра
     * @return string|\yii\web\Response|null
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        /** @var Parameter $parameter */
        $parameter = Parameter::findOne($id);
        $model = new ParameterEditForm;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $parameter->loadFromForm($model);
            if ($this->checkAccess($parameter)) {
                $parameter->save();
                return $this->redirect(['index', 'id_version' => $model->fid_quest]);
            }
        } else {
            $model->loadFromRecord($parameter);
            return $this->render('edit', [
                'model' => $model,
                'types' => ParameterType::find()->all(),
            ]);
        }
    }

    public function actionDelete($id)
    {
        /** @var Parameter $parameter */
        $parameter = Parameter::findOne($id);
        if ($this->checkAccess($parameter)) {

            if ($parameter->canDelete) {
                $parameter->delete();
            } else {
                throw new ForbiddenHttpException('Нельзя удалять параметр из рабочей версии квеста');
            }

            return $this->redirect(['index', 'id_version' => $parameter->fid_quest]);
        }
    }

}
