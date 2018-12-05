<?php

namespace common\components\telegram\eventHandlers;


use yii\base\Component;

class RegisterHandlers extends Component
{
    public function init() {
        parent::init();
        CreateProject::register();
    }
    
}