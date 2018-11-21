<?php

namespace frontend\modules\lk\controllers;


use frontend\modules\lk\models\Image;
use frontend\modules\lk\models\search\TaskSearch;
use common\models\tables\Tasks;
use yii\web\Controller;
use yii\web\UploadedFile;


class TaskController extends Controller
{
    public function behaviors() {
        return [
            'cache' => [
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
                'enabled' => false,
                'duration' => 3600,
                'variations' => [
                    \Yii::$app->language,
                    \Yii::$app->request->queryParams,
                    \Yii::$app->user->id,
                ],
                'dependency' => [
                    'class' => 'yii\caching\DbDependency',
                    'sql' => 'CHECKSUM TABLE tasks',
                ],
            ],
        ];
    }
    
    public function actionIndex() {
        $searchModel = new TaskSearch(['pageSize' => 10]);
        $searchModel->setAttribute('user_id', \Yii::$app->user->identity->id);
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
    
    public function actionView($id) {
        $model = Tasks::findOne($id);
        $imageModel = new Image();
        $dataProvider = Image::getDataProvider($id);
        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'imageModel' => $imageModel,
            'taskId' => $id,
        ]);
    }
    
    public function actionAddImage($id) {
        if (\Yii::$app->request->isPost) {
            $imageModel = new Image();
            $imageModel->image = UploadedFile::getInstance($imageModel, 'image');
            $imageModel->upload($id);
        }
        $this->redirect(['view', 'id' => $id]);
    }
    
    
}