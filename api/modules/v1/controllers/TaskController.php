<?php

namespace api\modules\v1\controllers;


use api\models\User;
use common\models\tables\Tasks;
use yii\filters\auth\HttpBasicAuth;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;

class TaskController extends ActiveController
{
    public $modelClass = Tasks::class;
    
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'auth' => function ($username, $password) {
                return User::authUser($username, $password);
            },
        
        ];
        return $behaviors;
    }
    
    protected function verbs() {
        return ArrayHelper::merge(
            parent::verbs(),
            [
                'complete' => ['PUT', 'PATCH'],
                'project' => ['GET', 'HEAD'],
                'user' => ['GET', 'HEAD'],
            ]
        );
    }
    
    
    public function checkAccess($action, $model = null, $params = []) {
        if ($action === 'create' && !\Yii::$app->user->can('createTask')) {
            throw new \yii\web\ForbiddenHttpException('Вы не можете создавать задачи');
        }
        if ($action === 'update' && !\Yii::$app->user->can('updateTask')) {
            throw new \yii\web\ForbiddenHttpException('Вы не можете редактировать задачи');
        }
        if ($action === 'delete' && !\Yii::$app->user->can('deleteTask')) {
            throw new \yii\web\ForbiddenHttpException('Вы не можете удалять задачи');
        }
        if (
            $action === 'complete'
            && !(\Yii::$app->user->can('productManager')
                || \Yii::$app->user->id === $model->user_id)
        ) {
            throw new \yii\web\ForbiddenHttpException('Вы не можете отметить задачу как выполненную');
        }
    }
    
    public function actionComplete($id) {
        return (new \api\modules\v1\models\Tasks())->complete($id);
    }
    
    public function actionProject($id) {
        return (new \api\modules\v1\models\Tasks())->getBy('project_id', $id);
    }
    
    public function actionUser($id) {
        return (new \api\modules\v1\models\Tasks())->getBy('user_id', $id);
    }
    
}