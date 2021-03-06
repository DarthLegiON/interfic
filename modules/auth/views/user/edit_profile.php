<?php

/* @var $model app\modules\auth\models\EditProfileForm */

use kartik\icons\Icon;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\base\models\User;

if (!empty($model->id)) :

$this->title = 'Редактирование профиля: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
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
]);
    echo $form->field($model, 'id', ['options' => ['class' => 'hidden']])->input('hidden');

    if ($model->role) {
        echo $form->field($model, 'role')->radioList(User::getRolesList(), ['separator' => '<br>']);
    }

    echo $form->field($model, 'avatar', [
        'template' => "{label}\n<div class=\"col-lg-7\">{input}</div>\n<div class=\"col-lg-3\">{error}</div>
                                <div class=\"col-lg-offset-2 col-lg-12 hint-block\">{hint}</div>",
    ])->widget(\kartik\widgets\FileInput::className(), [
        'pluginOptions' => [
            'allowedFileTypes' => ['image'],
            'allowedFileMimeTypes' => ['image/jpeg', 'image/png', 'image/gif'],
            'browseIcon' => Icon::show('folder-open'),
            'uploadIcon' => Icon::show('upload'),
            'removeIcon' => Icon::show('trash'),
            'maxFileSize' => 200,
            'maxImageWidth' => 160,
            'maxImageHeight' => 160,
        ]
    ]);
    echo '<br>';
    echo $form->field($model, 'passwordOld')->passwordInput();
    echo $form->field($model, 'passwordNew')->passwordInput();
    echo $form->field($model, 'passwordRepeat')->passwordInput(); ?>
    <div class="form-group">
        <label class="col-lg-2 control-label" for="editprofileform-bio">Подпись</label>

        <div class="col-lg-10">
            <?= \yii\imperavi\Widget::widget([
                'model' => $model,
                'attribute' => 'bio',
                'options' => [
                    'source' => false,
                    'buttons' => ['bold', 'italic', 'underline', 'image', 'link'],
                ],
                'plugins' => ['fontcolor'],
            ]); ?>
        </div>
    </div>

        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <?= Html::submitButton(Icon::show('floppy-o') . 'Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end();

else :

    $this->title = 'Пользователь не найден';

    ?>
    <h1>
        <?= Html::encode($this->title) ?>
    </h1>

<?php endif; ?>

