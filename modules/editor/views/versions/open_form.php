<?php

use app\modules\base\models\QuestVersion;
use app\modules\editor\models\VersionEditForm;
use kartik\helpers\Html;
use kartik\icons\Icon;
use yii\widgets\ActiveForm;

/** @var QuestVersion $version */
/** @var VersionEditForm $model */
?>
<div class="version-open">

    <?php $form = ActiveForm::begin([
        'id' => 'version-open-form',
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

    <?= $form->field($model, 'questName') ?>

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

    <?= $form->field($model, 'versionName') ?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
            <?= Html::submitButton(Icon::show('floppy-o') . 'Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
