<?php

use kartik\widgets\Alert;

/* @var $model \app\modules\base\models\QuestVersion */

$this->title = 'Удаление невозможно';
$this->params['breadcrumbs'][] = ['label' => 'Редактор квестов', 'url' => ['quest/index']];
$this->params['breadcrumbs'][] = ['label' => 'Редактирование', 'url' => ['quest/view', 'id' => $model->fid_quest]];

$this->params['breadcrumbs'][] = $this->title;

echo Alert::widget([
    'type' => Alert::TYPE_DANGER,
    'title' => 'Тестовую или рабочую версию удалить нельзя.'
]);