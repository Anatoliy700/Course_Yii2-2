<?php

namespace frontend\controllers;


use common\actions\task\AddImageAction;
use common\actions\task\CompletedAction;
use common\actions\task\DeleteImageAction;
use common\actions\task\ViewAction;
use common\models\TeamOptions;
use frontend\models\search\TaskSearch;
use yii\filters\AccessControl;
use yii\web\Controller;


class TaskController extends Controller
{
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'add-image', 'delete-image', 'completed'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'roles' => ['@'],
                        'allow' => true,
                    ],
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
        $searchModel = new TaskSearch(['pageSize' => 10]);
        $userId = \Yii::$app->user->identity->id;
        $searchModel->setAttribute('user_id', $userId);
        $dataProvider = $searchModel->search(\Yii::$app->request->post());
        $teamsDataProvider = (new TeamOptions())->getUserTeams($userId, true);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'teamsDataProvider' => $teamsDataProvider,
        ]);
    }
    
}