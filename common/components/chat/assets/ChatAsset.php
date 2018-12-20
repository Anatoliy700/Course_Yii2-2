<?php

namespace common\components\chat\assets;


use yii\web\AssetBundle;

class ChatAsset extends AssetBundle
{
    public $sourcePath = '@common/components/chat/web';
    
    public $js = [
        'js/taskChat.js'
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
        'themes\adminlte\assets\AdminLteAsset'
    ];
}