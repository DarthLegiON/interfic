<?php

use app\modules\base\models\QuestVersion;
use app\modules\editor\models\VersionEditForm;
use kartik\helpers\Html;
use yii\bootstrap\Tabs;

/** @var QuestVersion $version */
/** @var VersionEditForm $versionForm */

$this->title = 'Редактирование: ' . $version->name . ' (v.' . $version->versionCode . ')';
$this->params['breadcrumbs'][] = ['label' => 'Редактор квестов', 'url' => ['quest/index']];
$this->params['breadcrumbs'][] = ['label' => 'Редактирование: ' . $version->name, 'url' => ['quest/view', 'id' => $version->fid_quest]];
$this->params['breadcrumbs'][] = 'Версия ' . $version->versionCode;

?>

<h1><?= Html::encode($this->title) ?></h1>
<hr>
<h3>Общая информация</h3>

<dl class="dl-horizontal">
    <dt>Название версии</dt>
    <dd><?= $version->version_name ?></dd>
    <dt>Создатель</dt>
    <dd><?= $version->creatorUsername ?></dd>
    <dt>Код</dt>
    <dd><?= $version->versionCode ?></dd>
    <dt>Изменена</dt>
    <dd><?= Yii::$app->formatter->asDatetime($version->save_date, 'php:d.m.Y H:i:s') ?></dd>
</dl>

<?= Tabs::widget([
    'items' => [
        [
            'label' => 'Общая информация',
            'content' => $this->render('open_form', ['version' => $version, 'model' => $versionForm]),
            'active' => true,
        ],
        [
            'label' => 'Шаблоны',
            'url' => '#',
        ],
        [
            'label' => 'Параметры',
            'url' => '#',
        ],
        [
            'label' => 'Состояния',
            'url' => '#',
        ],
        [
            'label' => 'Изображения',
            'url' => '#',
        ],
        [
            'label' => 'Действия',
            'url' => '#',
        ],
    ]
]); ?>

