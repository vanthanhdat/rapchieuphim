<?php 
namespace app\assets;
use yii\web\AssetBundle;

/**
 * summary
 */
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
     public $css = [    
        'css/jquery.seat-charts.css',
    ];
    public $js = [
        'js/jquery.seat-charts.js',
    ];
    public $depends = [
        //'yii\web\YiiAsset',
        //'yii\web\JqueryAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
 ?>