<?php

namespace common\actions\task;


use common\models\Image;
use common\models\tables\Tasks;
use yii\base\Action;
use yii\web\UploadedFile;


class AddImageAction extends Action
{
    public $view = '@common/views/task/view';
    
    public function run($id) {
        $imageModel = new Image();
        $imageModel->image = UploadedFile::getInstance($imageModel, 'image');
        $imageModel->upload($id);
        
        $model = Tasks::findOne($id);
        $dataProvider = Image::getDataProvider($id);
//            return $this->redirect(['view', 'id' => $id]);
        return $this->controller->render($this->view, [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'imageModel' => $imageModel,
        ]);
    }
}