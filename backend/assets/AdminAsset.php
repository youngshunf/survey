<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot/AdminLTE';
    public $baseUrl = '@web/AdminLTE';
    public $css = [
        'dist/css/AdminLTE.min.css',
        'dist/css/skins/skin-blue.css',
        
    
    ];
    public $jsOptions=[
       'position'=> View::POS_HEAD
    ];
    public $js = [    

        'dist/js/app.min.js'       
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}
