<?php

use app\modules\base\models\QuestVersion;
use app\modules\editor\models\VersionEditForm;
use kartik\helpers\Html;
use yii\bootstrap\Collapse;

/** @var QuestVersion $version */
/** @var VersionEditForm $versionForm */

$this->title = 'Редактирование: ' . $version->name . ' (v.' . $version->versionCode . ')';
$this->params['breadcrumbs'][] = ['label' => 'Редактор квестов', 'url' => ['quest/index']];
$this->params['breadcrumbs'][] = ['label' => 'Редактирование: ' . $version->name, 'url' => ['quest/view', 'id' => $version->fid_quest]];
$this->params['breadcrumbs'][] = 'Версия ' . $version->versionCode;

?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('open_form', ['version' => $version, 'model' => $versionForm]) ?>

