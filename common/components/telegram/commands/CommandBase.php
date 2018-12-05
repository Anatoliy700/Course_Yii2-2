<?php

namespace common\components\telegram\commands;


use yii\base\Model;

abstract class CommandBase extends Model
{
    protected $message;
    
    abstract static public function getExpectedParams(): array;
    
    abstract public function run();
    
    public function getMessage() {
        return $this->message;
    }
}