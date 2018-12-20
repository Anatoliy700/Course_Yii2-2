<?php

namespace frontend\controllers;


use common\models\search\UsersInTeamSearch;
use common\models\tables\Teams;
use yii\filters\AccessControl;
use yii\web\Controller;

class TeamController extends Controller
{
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['view'],
                        'roles' => ['@'],
                        'allow' => true,
                    ]
                ]
            ]
        ];
    }
    
    public function actionView($id) {
        $team = Teams::findOne(['id' => $id]);
        $userSearch = new UsersInTeamSearch(['teamId' => $id]);
        $userDataProvider = $userSearch->search(\Yii::$app->request->queryParams);
        return $this->render('view', [
            'team' => $team,
            'userSearch' => $userSearch,
            'userDataProvider' => $userDataProvider
        ]);
    }
}