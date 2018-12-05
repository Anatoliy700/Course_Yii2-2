<?php

namespace common\components\telegram\commands;


use common\components\telegram\eventHandlers\CreateProject;
use yii\helpers\ArrayHelper;

abstract class SubscribeBase extends CommandBase
{
    protected $message;
    public $params;
    public $chat_id;
    
    public function __construct(array $config = []) {
        $this->params = $config['params'];
        $this->chat_id = $config['chat_id'];
        parent::__construct();
    }
    
    
    public function rules() {
        return [
            [['params', 'chat_id'], 'required'],
            [['chat_id'], 'integer', 'min' => 9],
            ['params', 'validateParams', 'params' => ['ExpectedParams' => static::getExpectedParams()]],
        ];
    }
    
    
    
    static public function getExpectedParams(): array {
        return [
            'newtask' => [
                'description' => 'Создание новой задачи',
            ],
            CreateProject::SUBSCRIBE_CREATE_PROJECT => [
                'description' => 'Создание нового проекта',
            ],
            'updateproject' => [
                'description' => 'Обновление проекта',
            ]
        ];
    }
    
    public function validateParams($attribute, $params) {
        if(count($this->$attribute) < 1){
            $this->addError($attribute, 'Необходимо передать хотябы один параметр');
        }
        
        foreach ($this->$attribute as $param){
            if(!ArrayHelper::keyExists($param , $params['ExpectedParams'])){
                $this->addError($attribute, "Не корректный параметр {{$param}}");
            }
        }
    }
    
    protected function getErrorString(){
        $str = '';
        foreach ($this->getErrors() as $errors){
            foreach ($errors as $error){
                $str .= $error . PHP_EOL;
            }
        }
        return $str;
    }
}