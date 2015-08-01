<?php

use kartik\icons\Icon;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $quest app\modules\base\models\Quest */
/* @var $versions yii\data\ActiveDataProvider */

if (!empty($quest)) :

    $this->title = $quest->name;
    $this->params['breadcrumbs'][] = ['label' => 'Редактор квестов', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;

    ?>

    <h1><?= Html::encode($this->title) ?></h1>



<?php else :

    $this->title = 'Квест не найден';
    $this->params['breadcrumbs'][] = ['label' => 'Редактор квестов', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;

    ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <h2>Версии</h2>

    <?= GridView::widget([
    'dataProvider' => $versions,
    'emptyCell' => '',
    'tableOptions' => ['class' => 'table table-bordered'],
    'columns' => [
        [
            'attribute' => 'name',
            'value' => function ($model, $key, $index, $column) {
                $canOpen = Yii::$app->user->can('manageQuests') || Yii::$app->user->can('createQuest') && Yii::$app->user->id == $model->fid_creator_user;
                if ($canOpen) {
                    return Html::a($model->name, ['quest-open?id=' . $model->id_quest]);
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

<?php endif; ?>
