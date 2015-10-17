<?php
/**
 * Created by PhpStorm.
 * User: Darth LegiON
 * Date: 16.08.2015
 * Time: 18:53
 */

use app\components\widgets\ActionButton;
use kartik\grid\GridView;
use kartik\helpers\Html;
use kartik\icons\Icon;

/** @var \yii\data\ActiveDataProvider $dataProvider */
/** @var \app\modules\base\models\QuestVersion $version */

$createDeleteEnabled = !($version->isProduction);

?>

<?= Html::a(Icon::show('plus') . 'Новый параметр', ['parameters/create', 'id_version' => $version->id_Quest_Version], ['class' => 'btn btn-success', 'disabled' => !$createDeleteEnabled]) ?>

<?= GridView::widget([

    'dataProvider' => $dataProvider,
    'emptyCell' => '',
    'export' => false,
    'columns' => [
        'name',
        'code',
        [
            'attribute' => 'type.name',
            'label' => 'Тип',
        ],
        'default_value',
        [
            'class' => \kartik\grid\ActionColumn::className(),
            'template' => '<div class="btn-group text-nowrap">{update}{duplicate}{delete}</div>',
            'urlCreator' => function ($action, $model, $key, $index) {
                switch ($action) {
                    case 'update':
                        return ['parameters/update', 'id' => $model->id_Parameter];
                    case 'delete':
                        return ['parameters/delete', 'id' => $model->id_Parameter];
                    case 'duplicate':
                        return ['parameters/create', 'id_version' => $model->fid_quest, 'id_current' => $model->id_Parameter];
                    default:
                        return '';
                }
            },
            'buttons' => [
                'duplicate' => function ($url, $model) {
                    return ActionButton::widget([
                        'icon' => 'clone',
                        'url' => $url,
                        'title' => 'Копировать...',
                        'buttonStyle' => 'btn-success',
                    ]);
                },
                'update' => function ($url, $model) {
                    return ActionButton::widget([
                        'icon' => 'pencil',
                        'url' => $url,
                        'title' => 'Изменить...',
                        'buttonStyle' => 'btn-primary',
                    ]);
                },
                'delete' => function ($url, $model) use ($createDeleteEnabled) {
                    return ActionButton::widget([
                        'icon' => 'trash',
                        'url' => $url,
                        'title' => $createDeleteEnabled ? 'Удалить параметр' : 'Нельзя удалять параметры в рабочей версии',
                        'enabled' => $createDeleteEnabled,
                        'confirmMessage' => $createDeleteEnabled ? 'Вы уверены?' : null,
                        'buttonStyle' => 'btn-danger',
                    ]);
                },
            ],
        ]
    ]
]);