<?php
/**
 * Created by PhpStorm.
 * User: Darth LegiON
 * Date: 09.08.2015
 * Time: 12:29
 */

namespace app\assets;


use yii\web\AssetBundle;

/**
 * Ассет для редактора квестов
 * @package app\assets
 */
class EditorAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/editor.css',
    ];
    public $depends = [
        'app\assets\AppAsset'
    ];
}