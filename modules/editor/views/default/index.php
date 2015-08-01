<?php

use kartik\icons\Icon;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Редактор квестов';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="editor-default-index">
    <h1><?= $this->title ?></h1>

    <?= Html::a(Icon::show('plus') . 'Создать новый квест', ['quest-create'], ['class' => 'btn btn-success']) ?>
    <br><br>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'emptyCell' => '',
        'tableOptions' => ['class' => 'table table-bordered'],
        'columns' => [
            [
                'attribute' => 'name',
                'value' => function ($model, $key, $index, $column) {
                    $canOpen = Yii::$app->user->can('manageQuests') || Yii::$app->user->can('createQuest') && Yii::$app->user->id == $model->fid_creator_user;
                    if ($canOpen) {
                        return Html::a($model->name, ['view', 'id' => $model->id_quest]);
                    } else {
                        return $model->name;
                    }
                },
                'format' => 'html',
            ],
            ['attribute' => 'description', 'format' => 'html'],
            'creatorUsername',
            ['attribute' => 'versionCode', 'format' => 'text']
        ]
    ]); ?>


</div>
