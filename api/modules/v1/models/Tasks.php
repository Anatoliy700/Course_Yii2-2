<?php

namespace api\modules\v1\models;


use yii\base\Model;
use yii\data\ActiveDataProvider;

class Tasks extends Model
{
    public function complete($id) {
        $model = \common\models\tables\Tasks::findOne($id);
        $model->setAttribute('status_id', \common\models\tables\Tasks::STATUS_COMPLETE);
        $model->save();
        return $model;
    }
    
    public function getBy(string $by, int $projectId) {
        $query = \common\models\tables\Tasks::find();
        $query->where([$by => $projectId]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        return $dataProvider;
    }
}