<?php

namespace common\actions\task;


use common\models\Image;
use common\models\search\ChatMessagesSearch;
use common\models\tables\ChatMessages;
use common\models\tables\Tasks;
use yii\base\Action;


class ViewAction extends Action
{
    public $view = '@common/views/task/view';
    
    public function run($id) {
        
        $model = Tasks::findOne($id);
        $imageModel = new Image();
        $dataProvider = Image::getDataProvider($id);
        $chatMessageModel = new ChatMessages();
        $chatDataProvider = (new ChatMessagesSearch())
            ->search(['ChatMessagesSearch' => ['task_id' => (int)$id]]);
        return $this->controller->render($this->view, [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'imageModel' => $imageModel,
            'chatMessageModel' => $chatMessageModel,
            'chatDataProvider' => $chatDataProvider,
        ]);
    }
}