<?php

/* @var $user app\modules\base\models\User */
/* @var $own boolean */
/* @var $admin boolean */

use kartik\icons\Icon;
use yii\helpers\Html;


if (!empty($user)) :

    $this->title = 'Профиль: ' . $user->login;
    $this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;

    ?>

    <div class="user-profile">

        <h1>
            <?= Html::encode($this->title) ?>
            <?php if ($own || $admin) {
                echo Html::a(Icon::show('pencil') . 'Редактировать...', ['/auth/user/edit-profile?id=' . $user->id_User], ['class' => 'btn btn-default btn-change-avatar']);
            } ?>
        </h1>
        <hr>

        <div class="full-avatar pull-left text-left">
            <?= ($user->avatar)
                    ? Html::img([$user->getAvatarFullPath()])
                    : Html::tag('div', 'Нет аватара')
            ?>
        </div>
        <dl class="dl-horizontal pull-left">
            <?php if ($own) : ?>
            <dt>Персональный код</dt>
            <dd><?= $user->id_User; ?></dd>
            <?php endif ?>
            <dt>Группа</dt>
            <dd><?= $user->getRoleName(); ?></dd>
            <dt>Зарегистирован</dt>
            <dd><?= Yii::$app->formatter->asDatetime($user->registration_time, 'php:d.m.Y H:i'); ?> (<?= $user->regDuration ?> дней)</dd>
            <dt>Квесты</dt>
            <dd>
                <?php $userQuests = $user->getQuests();
                if (count($userQuests) > 0) {
                    foreach ($user->getQuests() as $quest) {
                        /** @TODO Вывести список игр со ссылками на страницы */
                    }
                } else {
                    echo 'нет';
                }
                ?>
            </dd>
            <dt>Сыграно игр</dt>
            <dd><?= $user->getGamesCount(); ?></dd>
        </dl>
        <div class="clearfix"></div>
        <hr>
        <?php if ($user->bio) : ?>
        <h4>Подпись</h4>
        <div>
            <?= $user->bio ?>
        </div>
        <?php endif; ?>

        <?php if ($admin || $own) : ?>
        <h4>Дополнительная информация</h4>

        <dl class="dl-horizontal">
            <dt>E-mail</dt>
            <dd><?= $user->email; ?></dd>
            <dt>IP</dt>
            <dd><?= $user->ip_address; ?></dd>
        </dl>

        <?php endif; ?>
    </div>

<?php else :

    $this->title = 'Пользователь не найден';
    $this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;

    ?>
    <h1>
        <?= Html::encode($this->title) ?>
    </h1>

 <?php endif; ?>
