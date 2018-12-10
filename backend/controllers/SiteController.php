<?php

namespace backend\controllers;

use backend\models\Task;
use backend\models\Team;
use backend\models\User;
use yii\helpers\ArrayHelper;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends AdminController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        $behaviors = [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
        
        return ArrayHelper::merge(parent::behaviors(), $behaviors);
    }
    
    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        $staticUsers = User::getStatisticUsers();
        $teamsCount = Team::getCountTeams();
//        var_dump(Task::getCountOverdueTasks(Task::DAY_ONE));
        var_dump(Task::getStatisticTasks(Task::WEEK_ONE));
        //exit();
        return $this->render('index');
    }
    
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';
            
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout() {
        Yii::$app->user->logout();
        
        return $this->goHome();
    }
}
