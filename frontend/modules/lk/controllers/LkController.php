<?php

namespace frontend\modules\lk\controllers;


use yii\web\Controller;

class LkController extends Controller
{
    
    public function actionIndex() {
        return $this->render('index', [
            'user' => \Yii::$app->user->identity
        ]);
    }
    
    
}
