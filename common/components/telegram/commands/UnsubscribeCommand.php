<?php

namespace common\components\telegram\commands;


use common\components\telegram\models\Subscription;

class UnsubscribeCommand extends SubscribeBase
{
    //TODO: Добавить проверку подписан ли пользователь
    public function run() {
        if ($this->validate()) {
            $isError = false;
            $message = 'Подписка на ';
            foreach ($this->params as $param) {
                $subscribe = new Subscription(['subscribe_name' => $param, 'chat_id' => $this->chat_id]);
                if ($subscribe->delete()) {
                    $message .= $param . ' ';
                } else {
                    $isError = true;
                    var_dump($subscribe->getErrors());
                }
            }
            $message .= 'отключена';
            $this->message = $message;
            if ($isError) {
                $this->message = 'Что то пошло не так';
            }
        } else {
            $this->message = $this->getErrorString();
        }
    
    }
    
}