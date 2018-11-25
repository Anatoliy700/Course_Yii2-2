<?php

namespace frontend\models;

use common\models\tables\Tasks;
use yii\base\Model;

class Task extends Model
{
    public $id;
    public $date;
    public $title;
    public $description;
    public $user_id;
    
    public function rules() {
        return [
            [['id', 'user_id'], 'integer', 'min' => 1],
            [['title', 'description', 'user_id'], 'required'],
            ['date', 'date', 'format' => 'php:Y-m-d', 'min' => date('Y-m-d'), 'minString' => 'текущей'],
            ['title', 'string', 'length' => [5, 10]],
            //['title', 'app\components\validators\TaskStringValidator', 'length' => [5, 20], 'startWord' => 'Сделать'],
            ['description', 'string', 'min' => 5]
        ];
    }
    
    public function save() {
        if ($this->validate()) {
            if ($this->date == '') {
                $this->date = date('Y-m-d');
            }
        }
        if (isset($this->id)) {
            $model = Tasks::findOne($this->id);
        } else {
            $model = new Tasks();
        }
        $model->setAttributes($this->attributes);
        if ($model->save()) {
            $this->id = $this->id ?? $model->getPrimaryKey();
            return true;
        }
        return false;
    }
    
    static public function getOne($id) {
        $model = Tasks::findOne($id);
        $task = new static();
        $task->setAttributes($model->attributes);
        return $task;
    }
    
    public function attributeLabels() {
        return [
            'date' => 'Дата',
            'title' => 'Задача',
            'description' => 'Описание',
            'user_id' => 'Пользователь',
        ];
    }
}