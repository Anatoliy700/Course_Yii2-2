<?php

namespace frontend\models\search;


use yii\db\ActiveQuery;

class ProjectsSearch extends \common\models\search\ProjectsSearch
{
    public $countTotalTask;
    
    public function search($params) {
        /* @var $query ActiveQuery */
        $dataProvider = parent::search($params);
        $query = $dataProvider->query;
        $query->with('tasksComplete');
        return $dataProvider;
    }
}