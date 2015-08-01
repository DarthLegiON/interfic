<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $quest app\modules\base\models\Quest */
/* @var $versions yii\data\ActiveDataProvider */

if (!empty($quest)) :

    $this->title = $quest->name;
    $this->params['breadcrumbs'][] = ['label' => 'Редактор квестов', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;

    ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <h2>Версии</h2>

    <?= GridView::widget([

    'dataProvider' => $versions,
    'emptyCell' => '',
    'export' => false,
    'tableOptions' => ['class' => 'table table-bordered'],
    'columns' => [
        'name',
        ['attribute' => 'description', 'format' => 'html'],
        'versionCode',
        ['attribute' => 'save_date', 'format' => ['date', 'php:d.m.Y h:i:s']],
        'testProduction',
        ['class' => \kartik\grid\ActionColumn::className()]
    ]
]); ?>

<?php else :

    $this->title = 'Квест не найден';
    $this->params['breadcrumbs'][] = ['label' => 'Редактор квестов', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;

    ?>
    <h1><?= Html::encode($this->title) ?></h1>


<?php endif; ?>
