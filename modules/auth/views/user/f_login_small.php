<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\modules\auth\models\LoginForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\modules\auth\models\LoginForm */

?>

<?php

$model = new LoginForm();

$form = ActiveForm::begin([
    'id' => 'login-form-small',
    'options' => ['class' => 'form-horizontal'],
    'validateOnBlur' => false,
    'validateOnChange' => false,
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-sm-9\">{input}</div>",
        'labelOptions' => ['class' => 'col-sm-3 control-label'],
        'options' => ['class' => 'form-group form-group-sm'],
    ],
    'action' => ['/auth/user/login'],
]); ?>

<?= $form->field($model, 'username') ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<?= $form->field($model, 'rememberMe', [
    'template' => "<div class=\"col-sm-offset-3 col-lg-9\">{input} {label}</div>",
    'labelOptions' => ['class' => 'control-label'],
])->checkbox([], false) ?>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <?= Html::submitButton('Вход', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
            <?= Html::a('Регистрация', ['/auth/user/register'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>