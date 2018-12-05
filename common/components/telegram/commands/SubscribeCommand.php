<?php

namespace common\components\telegram\commands;


use common\components\telegram\models\Subscription;

class SubscribeCommand extends SubscribeBase
{
    //TODO: Добавить проверку на уже сущесвующую подписку
    public function run() {
        if ($this->validate()) {
            $isError = false;
            $message = 'Подписка на ';
            foreach ($this->params as $param) {
                $subscribe = new Subscription(['subscribe_name' => $param, 'chat_id' => $this->chat_id]);
                if ($subscribe->save()) {
                    $message .= $param . ' ';
                } else {
                    $isError = true;
                }
            }
            $message .= 'оформлена';
            $this->message = $message;
            if ($isError) {
                $this->message = 'Что то пошло не так';
            }
        } else {
            $this->message = $this->getErrorString();
        }
    }
}