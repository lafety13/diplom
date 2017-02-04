<?php
namespace app\assets;

use yii\web\AssetBundle;

class FontAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'http://fonts.googleapis.com/css?family=Roboto:400,400italic,300italic,300,500,500italic,700,900',
        'http://fonts.googleapis.com/css?family=Roboto+Slab:400,700,300,100'
    ];
    public $cssOptions = [
        'type' => 'text/css',
    ];
}