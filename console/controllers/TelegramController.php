<?php

namespace console\controllers;


use console\models\TelegramReceive;
use yii\console\Controller;

class TelegramController extends Controller
{
    public function actionStart(){
        $model = new TelegramReceive();
        var_dump($model->run());
    }
}