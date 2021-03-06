<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\EditorAsset;
use kartik\icons\Icon;

/* @var $this \yii\web\View */
/* @var $content string */

EditorAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= Yii::$app->request->baseUrl; ?>/favicon.ico" type="image/x-icon" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> - Interfic</title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Icon::show('home') . 'Interfic',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => [
            Yii::$app->user->isGuest ?
                [
                    'label' => Icon::show('sign-in') . 'Войти',
                    'items' => \yii\helpers\ArrayHelper::merge(Yii::$app->controller->route !== 'auth/user/login' ? [
                        '<div>' . $this->render('@app/modules/auth/views/user/f_login_small') . '</div>',
                        '<li class="divider"></li>',
                    ] : [], [
                        ['label' => Icon::show('users') . 'Пользователи', 'url' => ['/auth/user/index']],
                        ['label' => Icon::show('user-plus') . 'Регистрация', 'url' => ['/auth/user/register']],
                    ]),
                    'options' => ['class' => 'menu-user-login']
                ] :
                [
                    'label' => ((Yii::$app->user->identity->avatar) ? Html::img(['/uploads/avatars/' . Yii::$app->user->identity->avatar], ['class' => 'avatar']) : '<span class="avatar">&nbsp;</span>')
                        . Yii::$app->user->identity->username . '',
                    'options' => ['class' => 'menu-user-info'],
                    'items' => [
                        ['label' => Icon::show('users') . 'Пользователи', 'url' => ['/auth/user/index']],
                        ['label' => Icon::show('user') . 'Профиль', 'url' => ['/auth/user/profile']],
                        '<li class="divider"></li>',
                        ['label' => Icon::show('sign-out') . 'Выйти', 'url' => ['/auth/user/logout'], 'linkOptions' => ['data-method' => 'post'],],
                    ]
                ],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
