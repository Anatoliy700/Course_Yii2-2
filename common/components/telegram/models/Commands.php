<?php

namespace common\components\telegram\models;


use common\models\tables\TelegramCommands;

class Commands extends TelegramCommands
{
    
    public static function getLastId() {
        return static::find()->max('update_id');
    }
    
    public static function getNotExecutedCommands() {
        return static::find()
            ->where(['done' => false])
            ->all();
    }
    
    public function done() {
        $this->setAttribute('done', true);
        $this->save();
    }
}