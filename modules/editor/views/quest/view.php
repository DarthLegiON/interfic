<?php

use yii\helpers\Html;
use kartik\icons\Icon;

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
    <hr>
    <h3>
        Версии
        <?= Html::a(Icon::show('plus') . 'Новая версия', ['versions/create', 'id' => $quest->id_quest], ['class' => 'btn btn-success']) ?>
    </h3>
    <p>Выберите версию для редактирования. Текущая тестовая версия отмечена оранжевым, текущая рабочая - красным.</p>

    <?= $this->render('../versions/list', [
    'dataProvider' => $versions,
]) ?>

<?php else :

    $this->title = 'Квест не найден';
    $this->params['breadcrumbs'][] = ['label' => 'Редактор квестов', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;

    ?>
    <h1><?= Html::encode($this->title) ?></h1>


<?php endif; ?>
