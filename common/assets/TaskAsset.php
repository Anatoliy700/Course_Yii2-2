<?php

namespace common\assets;


use themes\adminlte\assets\AdminLteAsset;
use yii\web\AssetBundle;

class TaskAsset extends AssetBundle
{
    public $sourcePath = '@common/resources/task';
    
    public $css = [
        'css/task.css'
    ];
    
    public $depends = [
        AdminLteAsset::class
    ];
}