<?php

namespace common\actions\task;

use common\models\tables\Tasks;
use Yii;
use yii\base\Action;
use yii\db\Expression;


class CompletedAction extends Action
{
    public $view = '@common/views/task/view';
    
    
    public function run($id) {
        $model = Tasks::findOne($id);
        $model->scenario = Tasks::SCENARIO_COMPLETE;
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->setAttributes([
                'status_id' => Tasks::STATUS_COMPLETE,
                'done_date' => new Expression('NOW()')
            ]);
            $model->save();
        }
        return $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }
}