<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Hendri <hendri.gnw@gmail.com>
 */
class PrintAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/print.css',
    ];
    public $js = [];
}
