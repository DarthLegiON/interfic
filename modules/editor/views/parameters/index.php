<?php

use app\modules\base\models\QuestVersion;

/** @var QuestVersion $version */
/** @var \yii\data\ActiveDataProvider $parameters */


echo $this->render('@app/modules/editor/views/common/version-main', [
    'active' => 'parameters',
    'versionForm' => null,
    'version' => $version,
    'data' => [
        'parameters' => $parameters,
    ],
]);