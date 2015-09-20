<?php
/**
 * Created by PhpStorm.
 * User: Darth LegiON
 * Date: 16.08.2015
 * Time: 21:23
 */

use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\editor\models\ParameterEditForm */
/* @var $types \app\modules\base\models\ParameterType[] */
/* @var $form ActiveForm */

$this->title = isset($model->id_parameter) ? 'Редактирование параметра' : 'Новый параметр';
$this->params['breadcrumbs'][] = ['label' => 'Редактор квестов', 'url' => ['quest/index']];
$this->params['breadcrumbs'][] = ['label' => 'Редактирование', 'url' => ['parameters/index', 'id_version' => Yii::$app->request->get('id_version')]];

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="version-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
    <?php $form = ActiveForm::begin([
        'id' => 'parameter-edit-form',
        'options' => [
            'enctype' => 'multipart/form-data',
            'class' => 'form-horizontal',
        ],
        'validateOnBlur' => false,
        'validateOnChange' => false,
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>
                                <div class=\"col-lg-offset-2 col-lg-12 hint-block\">{hint}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'id_parameter', ['template' => '{input}'])->input('hidden') ?>
    <?= $form->field($model, 'fid_quest', ['template' => '{input}'])->input('hidden') ?>

    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'code') ?>
    <?= $form->field($model, 'type')->widget(Select2::className(), [
        'theme' => 'interfic',
        'data' => ArrayHelper::map($types, 'id_ParameterType', 'name')
    ]) ?>
    <?= $form->field($model, 'defaultValue') ?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
            <?= Html::submitButton(isset($model->id_parameter) ? Icon::show('floppy-o') . 'Сохранить' : Icon::show('plus') . 'Создать', ['class' => isset($model->id_parameter) ? 'btn btn-primary' : 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- version-create -->