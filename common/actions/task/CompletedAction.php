<?php

namespace common\actions\task;


use common\models\tables\Tasks;
use yii\base\Action;
use yii\db\Expression;


class CompletedAction extends Action
{
    public $view = '@common/views/task/view';
    
    
    public function run($id) {
        $model = Tasks::findOne($id);
        $model->setAttributes([
            'status_id' => Tasks::STATUS_COMPLETE,
            'done_date' => new Expression('NOW()')
        ]);
        $model->setAttribute('status_id', Tasks::STATUS_COMPLETE);
        $model->save();
        return $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }
}