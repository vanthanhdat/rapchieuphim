<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;
use yii\web\AssetBundle;
/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        //'css/jquery.seat-charts.css',
        'css/template/font-awesome.css',
        'css/template/animate.min.css',
        'css/template/style.default.css',
        'css/bootstrap-dropdownhover.css',
    ];
    public $js = [
        'js/template/respond.min.js',
        'js/main.js',
        //'js/jquery.seat-charts.js',
        'js/bootstrap-dropdownhover.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    
}
