<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\auth\models\RegisterForm */
/* @var $form ActiveForm */

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-register">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>Для регистрации заполните информацию ниже:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
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

        <?= $form->field($model, 'username') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'passwordRepeat')->passwordInput() ?>
        <?= $form->field($model, 'email')->input('email') ?>
        <?= $form->field($model, 'avatar')->fileInput() ?>
        <input type="hidden" name="MAX_FILE_SIZE" value="200000"/>
    
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- user-register -->
