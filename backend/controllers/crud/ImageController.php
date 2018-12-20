<?php

namespace backend\controllers\crud;

use backend\controllers\AdminController;
use backend\models\Image;
use backend\models\search\ImageSearch;
use common\models\tables\Images;
use common\models\tables\Tasks;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ImageController implements the CRUD actions for Images model.
 */
class ImageController extends AdminController
{
    
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return ArrayHelper::merge(parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]);
    }
    
    
    /**
     * Lists all Images models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ImageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Displays a single Images model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    /**
     * Creates a new Images model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Image();
        
        if (\Yii::$app->request->isPost) {
            $model->image = UploadedFile::getInstance($model, 'image');
            $modelName = (new \ReflectionClass($model))->getShortName();
            $model->task_id = \Yii::$app->request->post($modelName)['task_id'];
            $model->upload();
            return $this->redirect(['view', 'id' => $model->id]);
        }

//        $model = new Images();
        $tasks = Tasks::getArrAllTasks();
        
        return $this->render('create', [
            'model' => $model,
            'tasks' => $tasks,
        ]);
    }
    
    /**
     * Updates an existing Images model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $tasks = Tasks::getArrAllTasks();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        return $this->render('update', [
            'model' => $model,
            'tasks' => $tasks,
        ]);
    }
    
    /**
     * Deletes an existing Images model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        
        return $this->redirect(['index']);
    }
    
    /**
     * Finds the Images model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Images the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Image::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
