<?php
/* @var $this yii\web\View */
use kartik\icons\Icon;
use yii\helpers\Html;

$this->title = 'Interfic - главная';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Добро пожаловать в Interfic!</h1>

        <? if (Yii::$app->user->isGuest) : ?>
        <p>
            Чтобы начать играть, войдите или зарегистрируйтесь на сайте!
        </p>
        <? endif ?>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-12">
                <h1>У нас вы можете:</h1>
            </div>
            <div class="col-lg-4">
                <h3>Играть в квесты!</h3>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p>
                    <?= Html::a('Играть!&nbsp;' . Icon::show('angle-double-right'), ['/game/play/index'], ['class' => 'btn btn-default']); ?>
                </p>
            </div>
            <div class="col-lg-4">
                <h3>Создавать квесты!</h3>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p>
                    <?= Html::a('Редактор&nbsp;' . Icon::show('angle-double-right'), ['/editor/quest/index'], ['class' => 'btn btn-default']); ?>
                </p>
            </div>
            <div class="col-lg-4">
                <h3>Соревноваться с игроками!</h3>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p>
                    <?= Html::a('Пользователи&nbsp;' . Icon::show('angle-double-right'), ['/auth/user/index'], ['class' => 'btn btn-default']); ?>
                </p>
            </div>
        </div>
    </div>
</div>
