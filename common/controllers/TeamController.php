<?php

namespace common\controllers;


use common\models\search\TeamsSearch;
use yii\web\Controller;

class TeamController extends Controller
{
    public function actionIndex(){
        $searchModel = new TeamsSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
}