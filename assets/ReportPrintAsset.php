<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Hendri <hendri.gnw@gmail.com>
 */
class ReportPrintAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/report-print.css',
    ];
    public $js = [];
}
