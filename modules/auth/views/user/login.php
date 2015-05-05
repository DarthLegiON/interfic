<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\modules\auth\models\LoginForm */

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, войдите в систему под вашим логином и паролем:</p>

    <?= $this->render('f_login', ['model' => $model]);?>

    <div class="col-lg-offset-1" style="color:#999;">
        Если у вас нет логина/пароля, <a href="<?=Url::toRoute('user/register') ?>">зарегистрируйтесь</a> в системе.<br>
        Если вы забыли логин или пароль, воспользуйтесь формой <a href="<?=Url::toRoute('user/restore') ?>">восстановления</a> доступа.<br>
        Многократная регистрация запрещена.
    </div>
</div>
