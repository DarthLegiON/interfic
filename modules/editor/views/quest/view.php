<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $quest app\modules\base\models\Quest */
/* @var $versions yii\data\ActiveDataProvider */

if (!empty($quest)) :

    $this->title = 'Редактирование: ' . $quest->name;
    $this->params['breadcrumbs'][] = ['label' => 'Редактор квестов', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;

    ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <h3>Общая информация</h3>

    <dl class="dl-horizontal">
        <dt>Создатель</dt>
        <dd><?= $quest->creatorUsername ?></dd>
        <dt>Текущая версия</dt>
        <dd><?= $quest->versionCode ?></dd>
        <dt>Описание</dt>
        <dd><?= $quest->description ?></dd>
    </dl>

    <h3>Версии</h3>

    <p>Выберите версию для редактирования.</p>

    <?= GridView::widget([

    'dataProvider' => $versions,
    'emptyCell' => '',
    'export' => false,
    'tableOptions' => ['class' => 'table table-bordered'],
    'columns' => [
        'version_name',
        'versionCode',
        ['attribute' => 'save_date', 'format' => ['date', 'php:d.m.Y h:i:s']],
        'creatorUsername',
        'testProduction',
        [
            'class' => \kartik\grid\ActionColumn::className(),
            'template' => '{update} {delete}',
        ]
    ]
]); ?>

<?php else :

    $this->title = 'Квест не найден';
    $this->params['breadcrumbs'][] = ['label' => 'Редактор квестов', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;

    ?>
    <h1><?= Html::encode($this->title) ?></h1>


<?php endif; ?>
