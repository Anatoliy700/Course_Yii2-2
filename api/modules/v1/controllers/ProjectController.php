<?php

namespace api\modules\v1\controllers;


use api\models\User;
use common\models\tables\Projects;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class ProjectController extends ActiveController
{
    public $modelClass = Projects::class;
    
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'auth' => function ($username, $password) {
                return User::authUser($username, $password);
            },
        
        ];
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only' => ['create', 'update', 'delete'],
            'rules' => [
                [
                    'actions' => ['create', 'update'],
                    'roles' => ['productManager'],
                    'allow' => true
                ],
                [
                    'actions' => ['delete'],
                    'roles' => ['admin'],
                    'allow' => true
                ],
            ]
        ];
        return $behaviors;
    }
    
}