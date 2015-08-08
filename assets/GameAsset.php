<?php
/**
 * Created by PhpStorm.
 * User: Darth LegiON
 * Date: 08.08.2015
 * Time: 15:38
 */

namespace app\assets;


use yii\web\AssetBundle;

class GameAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/interfic.css',
        'css/theme1.css',
    ];
    public $js = [
        // TODO добавить игровые модули
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'app\assets\AppAsset'
    ];
}