<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use kartik\icons\Icon;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                            'items' => [
                                '<div>' . $this->render('@app/modules/auth/views/user/f_login_small') . '</div>',
                            ],
                            'options' => ['class' => 'menu-user-login']
                        ] :
                        [
                            'label' => ((Yii::$app->user->identity->avatar) ? Html::img(['/uploads/avatars/' . Yii::$app->user->identity->avatar], ['class' => 'avatar']) : '<span class="avatar">&nbsp;</span>')
                                . '&nbsp;' . Yii::$app->user->identity->username . '',
                            'options' => ['class' => 'menu-user-info'],
                            'items' => [
                                ['label' => Icon::show('user') . 'Профиль', 'url' => ['/auth/user/profile']],
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
