<?php

use app\modules\base\models\QuestVersion;
use app\modules\editor\models\VersionEditForm;

/** @var QuestVersion $version */
/** @var VersionEditForm $versionForm */


echo $this->render('@app/modules/editor/views/common/version-main', [
    'active' => 'info',
    'versionForm' => $versionForm,
    'version' => $version,
    'data' => [],
]);