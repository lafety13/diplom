<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'http://fonts.googleapis.com/css?family=Roboto:400,400italic,300italic,300,500,500italic,700,900',
        'http://fonts.googleapis.com/css?family=Roboto+Slab:400,700,300,100',
        'css/bootstrap.css',
        'css/font-awesome.css',
        'css/animate.css',
        'css/templatemo-misc.css',
        'css/templatemo-style.css',
        'css/site.css',
    ];
    public $js = [
        'js/plugins.js',
        'js/main.js',
        'js/vendor/modernizr-2.6.1-respond-1.1.0.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
