<?php
/**
 * Created by PhpStorm.
 * User: Darth LegiON
 * Date: 11.05.2015
 * Time: 12:10
 */

use app\modules\base\models\User;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\modules\auth\models\UserSearch */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
$admin = Yii::$app->user->can('manageUsers');
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-bordered'],
        'filterModel' => $searchModel,
        'emptyCell' => '',
        'export' => false,
        'rowOptions' => ['class' => 'row-vmiddle'],
        'columns' => [

            ['attribute' => 'id_User', 'filterInputOptions' => ['class' => 'form-control', 'style' => 'width: 40px']],
            [
                'label' => 'Никнейм',
                'attribute' => 'login',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a(
                        (($model->avatar) ? Html::img([$model->avatarFullPath], ['class' => 'avatar']) : Html::tag('span', '&nbsp;', ['class' => 'avatar']))
                    . $model->login . '',
                        ['profile?id=' . $model->id_User],
                        ['target' => '_blank', 'title' => 'Открыть профиль']
                    );
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'role',
                'value' => function ($model, $key, $index, $column) {
                    return $model->roleName;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'data' => \yii\helpers\ArrayHelper::merge([null => 'Все'], User::getRolesList()),
                    'theme' => 'interfic',
                ],
            ],
            ['attribute' => 'gamesCount'],
            ['attribute' => 'email', 'visible' => $admin, 'format' => 'email'],
            ['attribute' => 'ip_address', 'visible' => $admin],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    switch ($action) {
                        case 'update' :
                            return ['edit-profile?id=' . $model->id_User];
                        default:
                            return [];
                    }
                },
                'visible' => $admin,
            ],
        ]
    ]); ?>

</div>
