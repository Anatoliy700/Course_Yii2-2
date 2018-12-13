<?php

namespace common\actions\task;


use common\models\Image;
use common\models\tables\Tasks;
use yii\base\Action;


class DeleteImageAction extends Action
{
    public $view = '@common/views/task/view';
    
    public function run($imgId, $taskId) {
        Image::findOne($imgId)->delete();
//        return $this->redirect(['view', 'id' => $taskId]);
        
        $model = Tasks::findOne($taskId);
        $imageModel = new Image();
        $dataProvider = Image::getDataProvider($taskId);
//            return $this->redirect(['view', 'id' => $id]);
        return $this->controller->render($this->view, [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'imageModel' => $imageModel,
        ]);
    }
    
}