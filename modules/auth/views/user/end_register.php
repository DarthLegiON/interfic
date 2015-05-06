<?php

use yii\helpers\Html;

/* @var $model app\modules\auth\models\LoginForm */

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="user-end-register">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>Поздравляем, <?= $model->username ?>, регистрация завершена! Для подключения своей учетной записи к другому сайту, введите в поле "Код Interfic" следующий код:</p>
    <p><b></b><?= $id ?></b></p>

    <p>Осталось только <a>войти</a> с помощью заданных логина и пароля!</p>

</div>

