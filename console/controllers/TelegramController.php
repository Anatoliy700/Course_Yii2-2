<?php

namespace console\controllers;


use common\components\telegram\TelegramReceive;
use yii\console\Controller;

class TelegramController extends Controller
{
    public function actionReceiveStart() {
         TelegramReceive::run();
    }
}