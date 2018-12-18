<?php

namespace backend\models;

use common\models\tables\Tasks;
use yii\data\ActiveDataProvider;

class Task extends Tasks
{
    const DAY_ONE = 'DAY';
    const WEEK_ONE = 'WEEK';
    const MONTH_ONE = 'MONTH';
    
    protected $periods = [
        'day' => 'DAY',
        'week' => 'WEEK',
        'month' => 'MONTH'
    ];
    protected $defaultPeriodKey = 'week';
    
    public $id;
    public $date;
    public $title;
    public $description;
    public $user_id;
    
    public function rules() {
        return [
            [['title', 'description', 'user_id', 'status_id', 'project_id'], 'required'],
            [['user_id', 'status_id', 'project_id'], 'integer', 'min' => 1],
            ['date', 'date', 'format' => 'php:Y-m-d', 'min' => date('Y-m-d'), 'minString' => 'текущей'],
            ['title', 'string', 'length' => [5, 10]],
            //['title', 'app\components\validators\TaskStringValidator', 'length' => [5, 20], 'startWord' => 'Сделать'],
            ['description', 'string', 'min' => 5]
        ];
    }
    
    
    public function save($runValidation = true, $attributeNames = null) {
        if ($this->validate()) {
            if ($this->date == '') {
                $this->date = date('Y-m-d');
            }
        }
        $model = new Tasks();
        $model->setAttributes($this->attributes);
        if ($model->save()) {
            $this->id = $model->getPrimaryKey();
            return true;
        }
        return false;
    }
    
    static public function getCountAllTasks() {
        return Tasks::find()->count();
    }
    
    static public function getCountDoneTasks(string $key) {
        return count((new static())->getDoneTasks($key));
    }
    
    static public function getCountOverdueTasks($key) {
        return count((new static())->getOverdueTasks($key));
    }
    
    static public function getStatisticTasks($key) {
        $all = static::getCountAllTasks();
        $done = static::getCountDoneTasks($key);
        $overdue = static::getCountOverdueTasks($key);
        
        return [
            'all' => (int)$all,
            'done' => (int)$done,
            'overdue' => (int)$overdue,
            'inWork' => $all - ($done + $overdue)
        ];
    }
    
    public function getDoneTasks(string $key, $dataProviderType = false) {
        $period = $this->getPeriodParam($key);
        $query = Tasks::find()
            ->andWhere('status_id = 2')
            ->andWhere('tasks.done_date < now()')
            ->andWhere("tasks.done_date >= adddate(now(), INTERVAL -1 {$period})");
        
        if ($dataProviderType) {
            return new ActiveDataProvider([
                'query' => $query
            ]);
        }
        return $query->all();
    }
    
    public function getOverdueTasks($key, $dataProviderType = false) {
        $period = $this->getPeriodParam($key);
        $query = Tasks::find()
            ->andWhere('status_id = 1')
            ->andWhere('tasks.date < now()')
            ->andWhere("tasks.date >= adddate(now(), INTERVAL -1 {$period})");
        
        if ($dataProviderType) {
            return new ActiveDataProvider([
                'query' => $query
            ]);
        }
        return $query->all();
    }
    
    protected function getPeriodParam($key) {
        if (key_exists($key, $this->periods)) {
            return $this->periods[$key];
        }
        return $this->periods[$this->defaultPeriodKey];
    }
}