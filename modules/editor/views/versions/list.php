<?php

use app\components\widgets\ActionButton;
use kartik\grid\GridView;
use kartik\helpers\Html;
use kartik\icons\Icon;

/* @var $dataProvider yii\data\ActiveDataProvider */

echo GridView::widget([

    'dataProvider' => $dataProvider,
    'emptyCell' => '',
    'export' => false,
    /*'rowOptions' => function ($model, $key, $index, $grid) {
        return [
            'class' => $model->isProduction
            ? 'danger'
            : ($model->isTest
                ? 'warning'
                : null
            )
        ];
    },*/
    'columns' => [
        [
            'attribute' => 'versionCode',
            'format' => 'html',
            'value' => function ($model, $key, $index, $column) {
                $iconTest = ($model->isTest) ? Icon::show('wrench', ['class' => 'text-warning']) : '';
                $iconProduction = ($model->isProduction) ? Icon::show('rocket', ['class' => 'text-danger']) : '';
                return $model->versionCode . $iconTest . $iconProduction;
            },
        ],
        'version_name',
        'startVersionCode',
        ['attribute' => 'save_date', 'format' => ['date', 'php:d.m.Y h:i:s']],
        'creatorUsername',
        [
            'class' => \kartik\grid\ActionColumn::className(),
            'template' => '<div class="btn-group text-nowrap">{test}{production}</div>',
            'header' => '',
            'urlCreator' => function ($action, $model, $key, $index) {
                switch ($action) {
                    case 'test':
                        return ['versions/test', 'id' => $model->id_Quest_Version];
                    case 'production':
                        return ['versions/production', 'id' => $model->id_Quest_Version];
                    default:
                        return '';
                }
            },
            'buttons' => [
                'test' => function ($url, $model) {
                    return ActionButton::widget([
                        'enabled' => !$model->isTest,
                        'icon' => 'wrench',
                        'confirmMessage' => 'Переключить тестирование квеста на данную версию?',
                        'url' => $url,
                        'disabledClass' => 'active-version-icon',
                        'title' => $model->isTest ? 'Тестовая версия' : 'Сделать тестовой',
                        'buttonStyle' => 'btn-warning',
                    ]);
                },
                'production' => function ($url, $model) {
                    return ActionButton::widget([
                        'enabled' => !$model->isProduction,
                        'icon' => 'rocket',
                        'confirmMessage' => 'Рабочая версия квеста будет переключена на данную версию. Вы уверены?',
                        'url' => $url,
                        'disabledClass' => 'active-version-icon',
                        'title' => $model->isProduction ? 'Рабочая версия' : 'Сделать рабочей',
                        'buttonStyle' => 'btn-danger',
                    ]);
                },
            ],
            'contentOptions' => [
                'class' => 'text-nowrap',
            ]
        ],
        [
            'class' => \kartik\grid\ActionColumn::className(),
            'template' => '{update}{create}{delete} {test}{production}',
            'urlCreator' => function ($action, $model, $key, $index) {
                switch ($action) {
                    case 'update':
                        return ['versions/open', 'id' => $model->id_Quest_Version];
                    case 'delete':
                        return ['versions/delete', 'id' => $model->id_Quest_Version];
                    case 'create':
                        return ['versions/create', 'id' => $model->fid_quest, 'id_start' => $model->id_Quest_Version];
                    default:
                        return '';
                }
            },
            'buttons' => [
                'create' => function ($url, $model) {
                    return ActionButton::widget([
                        'icon' => 'plus',
                        'url' => $url,
                        'title' => 'Создать новую версию',
                        'buttonStyle' => 'btn-success',
                    ]);
                },
                'update' => function ($url, $model) {
                    return ActionButton::widget([
                        'icon' => 'pencil',
                        'url' => $url,
                        'title' => 'Открыть версию на редактирование',
                        'buttonStyle' => 'btn-primary',
                    ]);
                },
                'delete' => function ($url, $model) {
                    $enabled = !($model->isTest || $model->isProduction);
                    return ActionButton::widget([
                        'icon' => 'trash',
                        'url' => $url,
                        'title' => $enabled ? 'Удалить версию' : 'Тестовую или рабочую версию удалить нельзя',
                        'enabled' => $enabled,
                        'confirmMessage' => $enabled ? 'Версия будет безвозвратно удалена, вы согласны?' : null,
                        'buttonStyle' => 'btn-danger',
                    ]);
                },
            ],
        ]
    ]
]);