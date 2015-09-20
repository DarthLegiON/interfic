<?php
/**
 * Created by PhpStorm.
 * User: Darth LegiON
 * Date: 16.08.2015
 * Time: 18:35
 */

use kartik\helpers\Html;
use yii\bootstrap\Tabs;

/** @var \app\modules\base\models\QuestVersion $version */
/** @var \app\modules\editor\models\VersionEditForm $versionForm */
/** @var string $active */
/** @var array $data */

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
            'content' => $active === 'info'
                ? $this->render('../versions/open_form', ['version' => $version, 'model' => $versionForm])
                : null,
            'url' => $active !== 'info' ? ['versions/open', 'id' => $version->id_Quest_Version] : null,
            'active' => $active === 'info',
        ],
        [
            'label' => 'Шаблоны',
            'url' => '#',
        ],
        [
            'label' => 'Параметры ' . Html::tag('span', $version->parametersCount, ['class' => 'badge']),
            'content' => $active === 'parameters'
                ? $this->render('../parameters/list', ['version' => $version, 'dataProvider' => $data['parameters']])
                : null,
            'url' => $active !== 'parameters' ? ['parameters/index', 'id_version' => $version->id_Quest_Version] : null,
            'active' => $active === 'parameters',
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
    ],
    'encodeLabels' => false,
]); ?>
