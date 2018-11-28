<?php

namespace app\frontend\components\chat\assets;


use yii\web\AssetBundle;

class ChatAsset extends AssetBundle
{
    public $sourcePath = '@app/components/chat/web';
    
    public $js = [
        'js/taskChat.js'
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
        'themes\adminlte\assets\AdminLteAsset'
    ];
}