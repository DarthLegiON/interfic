<?php

use kartik\icons\Icon;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\editor\models\QuestCreateForm */
/* @var $form ActiveForm */

$this->title = 'Новый квест';
$this->params['breadcrumbs'][] = ['label' => 'Редактор квестов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-register">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>Выберите название для своего квеста:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'quest-create-form',
        'options' => [
            'enctype' => 'multipart/form-data',
            'class' => 'form-horizontal',
        ],
        'validateOnBlur' => false,
        'validateOnChange' => false,
        'fieldConfig' => [
            'template' => "{label}<div class=\"col-lg-3\">{input}</div><div class=\"col-lg-7\">{error}</div>
                                <div class=\"col-lg-offset-2 col-lg-12 hint-block\">{hint}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'description', [
        'template' => "{label}<div class=\"col-lg-7\">{input}</div><div class=\"col-lg-3\">{error}</div>
                                <div class=\"col-lg-offset-2 col-lg-12 hint-block\">{hint}</div>"
    ])->widget(\yii\imperavi\Widget::className(), [
        'model' => $model,
        'attribute' => 'description',
        'options' => [
            'source' => false,
            'buttons' => ['bold', 'italic', 'underline', 'image', 'link'],
        ],
        'plugins' => ['fontcolor'],
    ]) ?>
    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
            <?= Html::submitButton(Icon::show('plus') . 'Создать', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- user-register -->