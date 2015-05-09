<?php

/* @var $model app\modules\auth\models\EditProfileForm */

use kartik\icons\Icon;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

if (!empty($model->id)) :

$this->title = 'Редактирование профиля: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['list']];
$this->params['breadcrumbs'][] = ['label' => 'Профиль: ' . $model->username, 'url' => ['profile?id=' . $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';

echo '<h1>' . Html::encode($this->title) . '</h1>';

$form = ActiveForm::begin([
    'id' => 'edit-profile-form',
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
        <?= $form->field($model, 'id', ['options' => ['class' => 'hidden']])->input('hidden') ?>
        <?= $form->field($model, 'passwordOld')->passwordInput() ?>
        <?= $form->field($model, 'passwordNew')->passwordInput() ?>
        <?= $form->field($model, 'passwordRepeat')->passwordInput() ?>
        <?= $form->field($model, 'avatar')->fileInput() ?>
        <input type="hidden" name="MAX_FILE_SIZE" value="200000"/>

        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end();

else :

    $this->title = 'Пользователь не найден';

    ?>
    <h1>
        <?= Html::encode($this->title) ?>
    </h1>

<? endif; ?>

