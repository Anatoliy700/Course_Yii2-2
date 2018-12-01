<?php

namespace frontend\controllers;


use common\models\search\ChatMessagesSearch;
use common\models\tables\ChatMessages;
use common\models\tables\Projects;
use common\models\tables\TaskStatuses;
use common\models\tables\Users;
use frontend\models\Task;
use yii\filters\AccessControl;
use yii\web\Controller;
use frontend\models\search\TaskSearch;
use common\models\tables\Tasks;
use common\models\Image;
use yii\web\UploadedFile;


class TaskController extends Controller
{
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'update', 'delete', 'add-image', 'delete-image'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'roles' => ['createTask'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['update'],
                        'roles' => ['updateTask'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['delete'],
                        'roles' => ['deleteTask'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['add-image'],
                        'roles' => ['@'],
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
                        'actions' => ['task-complete'],
                        'roles' => ['@'],
                        'verbs' => ['POST'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }
    
    public function actionIndex($project_id) {
        $project = Projects::findOne($project_id);
        $searchModel = new TaskSearch(['pageSize' => 10]);
        $searchModel->setAttribute('project_id', $project_id);
//        $searchModel->setAttribute('date', date('Y-m'));
        $dataProvider = $searchModel->search(\Yii::$app->request->post());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'project' => $project,
        ]);
    }
    
    public function actionView($id) {
        $model = Tasks::findOne($id);
        $imageModel = new Image();
        $dataProvider = Image::getDataProvider($id);
        $chatMessageModel = new ChatMessages();
        $chatDataProvider = (new ChatMessagesSearch())
            ->search(['ChatMessagesSearch' => ['task_id' => (int)$id]]);
        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'imageModel' => $imageModel,
            'chatMessageModel' => $chatMessageModel,
            'chatDataProvider' => $chatDataProvider,
        ]);
    }
    
    public function actionCreate($project_id) {
        $model = new Task([
            'project_id' => $project_id,
            'status_id' => Tasks::STATUS_IN_WORK,
        ]);
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        $project = Projects::findOne($project_id);
        $model->project = $project;
        return $this->render('create', [
            'model' => $model,
            'users' => Users::getUsersSelect(),
        ]);
    }
    
    public function actionUpdate($id) {
        $model = Task::getOne($id);
        $users = Users::getUsersSelect();
        $statuses = TaskStatuses::getStatusesSelect();
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
            'users' => $users,
            'statuses' => $statuses,
        ]);
    }
    
    public function actionDelete($id) {
        $model = Tasks::findOne($id);
        $project_id = $model->project_id;
        $model->delete();
        return $this->redirect(['index', 'project_id' => $project_id]);
    }
    
    public function actionAddImage($id) {
        $imageModel = new Image();
        $imageModel->image = UploadedFile::getInstance($imageModel, 'image');
        $imageModel->upload($id);
        
        $model = Tasks::findOne($id);
        $dataProvider = Image::getDataProvider($id);
//            return $this->redirect(['view', 'id' => $id]);
        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'imageModel' => $imageModel,
        ]);
    }
    
    public function actionDeleteImage($imgId, $taskId) {
        Image::findOne($imgId)->delete();
//        return $this->redirect(['view', 'id' => $taskId]);
        
        $model = Tasks::findOne($taskId);
        $imageModel = new Image();
        $dataProvider = Image::getDataProvider($taskId);
//            return $this->redirect(['view', 'id' => $id]);
        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'imageModel' => $imageModel,
        ]);
    }
    
    public function actionTaskComplete($id) {
        $model = Tasks::findOne($id);
        $model->setAttribute('status_id', Tasks::STATUS_COMPLETE);
        $model->save();
        return $this->render('view', [
            'model' => $model,
        ]);
    }
}