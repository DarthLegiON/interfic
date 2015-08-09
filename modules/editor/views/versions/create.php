<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\editor\models\VersionCreateForm */
/* @var $versionsList string[] */
/* @var $form ActiveForm */

$this->title = 'Новая версия квеста';
$this->params['breadcrumbs'][] = ['label' => 'Редактор квестов', 'url' => ['quest/index']];
$this->params['breadcrumbs'][] = ['label' => 'Редактирование', 'url' => ['quest/view', 'id' => Yii::$app->request->get('id')]];

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-register">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'version-create-form',
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

    <?= $form->field($model, 'versionName') ?>
    <?= $form->field($model, 'startVersion')->widget(Select2::className(), [
        'theme' => 'interfic',
        'data' => $versionsList
    ]) ?>
    <?= $form->field($model, 'isTest')->widget(\kartik\checkbox\CheckboxX::className(), [
        'pluginOptions'=>['threeState'=>false]
    ]) ?>
    <?= $form->field($model, 'isNewRelease')->widget(\kartik\checkbox\CheckboxX::className(), [
        'pluginOptions'=>['threeState'=>false]
    ]) ?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
            <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- user-register -->