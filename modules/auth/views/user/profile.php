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
            <? if ($own || $admin) {
                echo Html::a(Icon::show('pencil') . 'Редактировать...', ['/auth/user/edit-profile?id=' . $user->id_User], ['class' => 'btn btn-default btn-change-avatar']);
            } ?>
        </h1>


        <div class="full-avatar pull-left text-left">
            <?= ($user->avatar)
                    ? Html::img([$user->getAvatarFullPath()])
                    : Html::tag('div', 'Нет аватара')
            ?>
        </div>
        <? if ($own) : ?>
        <p>
            <b>Персональный код:</b> <?= $user->id_User; ?>
        </p>
        <? endif ?>
        <p>
            <b>Группа:</b> <?= $user->getRoleName(); ?>
        </p>
        <p>
            <b>Квесты:</b>&nbsp;
            <? $userQuests = $user->getQuests();
            if (count($userQuests) > 0) {
                foreach ($user->getQuests() as $quest) {
                    /** @TODO Вывести список игр со ссылками на страницы */
                }
            } else {
                echo 'нет';
            }
            ?>
        </p>
        <p>
            <b>Сыграно игр:</b> <?= $user->getGamesCount(); ?>
        </p>
        <div class="clearfix"></div>

        <? if ($user->bio) : ?>
        <h4>Подпись</h4>
        <div>
            <?= $user->bio ?>
        </div>
        <? endif; ?>

        <? if ($admin || $own) : ?>
        <h4>Дополнительная информация</h4>
            <table class="table">
                <colgroup>
                    <col width="250px">
                </colgroup>
                <tr>
                    <th>Регистрационный E-mail:</th>
                    <td><?= $user->email; ?></td>
                </tr>
                <tr>
                    <th>Регистрационный IP:</th>
                    <td><?= $user->ip_address; ?></td>
                </tr>
            </table>
        <? endif; ?>
    </div>

<? else :

    $this->title = 'Пользователь не найден';
    $this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;

    ?>
    <h1>
        <?= Html::encode($this->title) ?>
    </h1>

 <? endif; ?>
