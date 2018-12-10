<?php

namespace backend\models;

use common\models\tables\Tasks;

class Task extends Tasks
{
    const DAY_ONE = 'DAY';
    const WEEK_ONE = 'WEEK';
    const MONTH_ONE = 'MONTH';
    
    public $id;
    public $date;
    public $title;
    public $description;
    public $user_id;
    static protected $taskDbClass = '\app\models\tables\Tasks';
    
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
    
    static public function getCountDodeTasks(string $period) {
        return count(static::getDoneTasks($period));
    }
    
    static public function getCountOverdueTasks($period = null) {
        return count(static::getOverdueTasks($period));
    }
    
    static public function getStatisticTasks($period) {
        $all = static::getCountAllTasks();
        $done = static::getCountDodeTasks($period);
        $overdue = static::getCountOverdueTasks($period);
        
        return [
            'all' => (int)$all,
            'done' => (int)$done,
            'overdue' => (int)$overdue,
            'inWork' => $all - ($done + $overdue)
        ];
    }
    
    //TODO: поправить поле с датой выполнения задачи
    static public function getDoneTasks(string $period) {
        return Tasks::find()
            ->andWhere('status_id = 2')
            ->andWhere('tasks.updated_at < now()')
            ->andWhere("tasks.updated_at >= adddate(now(), INTERVAL -1 {$period})")
            ->all();
    }
    
    static public function getOverdueTasks($period = null) {
        $query = Tasks::find()
            ->andWhere('status_id = 1')
            ->andWhere('tasks.date < DATE(now())');
        
        if (!is_null($period)) {
            $query->andWhere("tasks.date >= adddate(DATE(now()), INTERVAL -1 {$period})");
        }
        return $query->all();
    }
}