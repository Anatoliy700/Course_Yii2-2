<?php

namespace frontend\controllers;


use frontend\models\search\ProjectsSearch;
use yii\web\Controller;
use yii\web\ErrorAction;

class ProjectController extends Controller
{
    public function actions() {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }
    
    public function actionIndex() {
        $searchModel = new ProjectsSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->post());
        return $this->render(
            'index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }
}