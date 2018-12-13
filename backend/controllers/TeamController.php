<?php

namespace backend\controllers;

use common\models\search\TeamsSearch;
use common\models\tables\Teams;
use common\models\TeamOptions;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

class TeamController extends AdminController
{
    
    public function behaviors() {
        return ArrayHelper::merge(parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                        'delete-user' => ['POST'],
                    ],
                ],
            ]);
    }
    
    
    public function actionIndex() {
        $searchModel = new TeamsSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
    
    public function actionView($teamId) {
        $teamModel = Teams::findOne($teamId);
        return $this->render('view', ['teamModel' => $teamModel]);
    }
    
    public function actionDeleteUser($teamId, $userId) {
        $teamOptions = new TeamOptions(['id' => $teamId]);
        $teamModel = $teamOptions->deleteUser($userId);
        return $this->render('view', ['teamModel' => $teamModel]);
    }
    
    public function actionAddUsers($teamId) {
        if (\Yii::$app->request->isPost && !is_null(\Yii::$app->request->post('usersId'))) {
            $teamOptions = new TeamOptions(['id' => $teamId]);
            $result = $teamOptions->addUsers(\Yii::$app->request->post('usersId'));
            if ($result > 0) {
                \Yii::$app->session->setFlash('addUsers', $result);
                return $this->redirect(['view', 'teamId' => $teamId]);
            }
        }
        $teamOptions = new TeamOptions(['id' => $teamId]);
        $teamModel = $teamOptions->getTeam();
        $usersSearch = $teamOptions->getUsersSearchNotInTeam();
        $usersDataProvider = $usersSearch->search(\Yii::$app->request->queryParams);
        return $this->render(
            'add-users',
            [
                'usersSearch' => $usersSearch,
                'usersDataProvider' => $usersDataProvider,
                'teamModel' => $teamModel,
            ]
        );
    }
    
    public function actionCreate() {
        $model = new Teams();
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'teamId' => $model->id]);
        }
        
        return $this->render('create', ['model' => $model]);
    }
    
    public function actionDelete($teamId) {
        (Teams::findOne($teamId))->delete();
        return $this->redirect(['team/index']);
    }
    
}