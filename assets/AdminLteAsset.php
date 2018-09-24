<?php 
namespace app\assets;
use yii\web\AssetBundle;

/**
 * summary
 */
class AdminLTEAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [    
     'css/AdminLTE.css',
     'css/style-admin.css',
 ];
 public $js = [
        'js/AdminLTE.min.js',
 ];
 public $depends = [
    'rmrevin\yii\fontawesome\AssetBundle',
    'yii\web\YiiAsset',
    'yii\bootstrap\BootstrapAsset',
    'yii\bootstrap\BootstrapPluginAsset',
];
public $skin = '_all-skins';
public function init()
{
    if ($this->skin) {
        if (('_all-skins' !== $this->skin) && (strpos($this->skin, 'skin-') !== 0)) {
            throw new Exception('Invalid skin specified');
        }

        $this->css[] = sprintf('css/skins/%s.min.css', $this->skin);
    }
    parent::init();
}
}
?>