<?php

namespace backend\controllers;


use backend\models\search\TaskSearch;
use common\actions\task\AddImageAction;
use common\actions\task\CompletedAction;
use common\actions\task\DeleteImageAction;
use common\actions\task\ViewAction;
use common\models\tables\Projects;
use common\models\tables\Tasks;
use common\models\tables\TaskStatuses;
use common\models\tables\Users;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

class TaskController extends AdminController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return ArrayHelper::merge(parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                        'delete-image' => ['POST'],
                        'completed' => ['POST'],
                    ],
                ],
            ]);
    }
    
    
    public function actionIndex() {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
    
    public function actions() {
        return [
            'view' => ViewAction::class,
            'add-image' => AddImageAction::class,
            'delete-image' => DeleteImageAction::class,
            'completed' => CompletedAction::class,
        ];
    }
    
    public function actionView($id) {
        $model = Tasks::findOne($id);
        return $this->render('view', ['model' => $model]);
    }
    
    public function actionCreate() {
        $model = new Tasks();
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $usersSelect = Users::getUsersSelect();
        $projectsSelect = Projects::getProjectsSelect();
        $statusesSelect = TaskStatuses::getStatusesSelect();
        
        return $this->render('create', [
            'model' => $model,
            'usersSelect' => $usersSelect,
            'projectsSelect' => $projectsSelect,
            'statusesSelect' => $statusesSelect,
        ]);
    }
    
    public function actionUpdate($id) {
        $model = Tasks::findOne($id);
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $usersSelect = Users::getUsersSelect();
        $projectsSelect = Projects::getProjectsSelect();
        $statusesSelect = TaskStatuses::getStatusesSelect();
        
        return $this->render('update', [
            'model' => $model,
            'usersSelect' => $usersSelect,
            'projectsSelect' => $projectsSelect,
            'statusesSelect' => $statusesSelect,
        ]);
    }
    
    public function actionDelete($id) {
        (Tasks::findOne($id))->delete();
        return $this->redirect(['index']);
    }
}