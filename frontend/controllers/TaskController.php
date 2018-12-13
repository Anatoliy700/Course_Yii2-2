<?php

namespace frontend\controllers;


use common\actions\task\AddImageAction;
use common\actions\task\CompletedAction;
use common\actions\task\DeleteImageAction;
use common\actions\task\ViewAction;
use common\models\tables\Projects;
use common\models\tables\Tasks;
use common\models\tables\TaskStatuses;
use common\models\tables\Users;
use frontend\models\search\TaskSearch;
use frontend\models\Task;
use yii\filters\AccessControl;
use yii\web\Controller;


class TaskController extends Controller
{
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['add-image', 'delete-image', 'completed'],
                'rules' => [
                    [
                        'actions' => ['add-image'],
                        'roles' => ['@'],
                        'verbs' => ['POST'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['delete-image'],
                        'roles' => ['productManager'],
                        'verbs' => ['POST'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['add-image'],
                        'roles' => ['productManager'],
                        'verbs' => ['POST'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['completed'],
                        'roles' => ['@'],
                        'verbs' => ['POST'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }
    
    
    public function actions() {
        return [
            'view' => ViewAction::class,
            'add-image' => AddImageAction::class,
            'delete-image' => DeleteImageAction::class,
            'completed' => CompletedAction::class,
        ];
    }
    
    public function actionIndex() {
        //$project = Projects::findOne($project_id);
        $searchModel = new TaskSearch(['pageSize' => 10]);
        //$searchModel->setAttribute('project_id', $project_id);
//        $searchModel->setAttribute('date', date('Y-m'));
        $dataProvider = $searchModel->search(\Yii::$app->request->post());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            //'project' => $project,
        ]);
    }
    
}