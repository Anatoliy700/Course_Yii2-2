<?php

namespace common\components\telegram\eventHandlers;


use common\components\telegram\models\Subscription;
use common\components\telegram\TelegramBase;
use common\models\tables\Projects;
use yii\base\Event;

class CreateProject extends TelegramBase
{
    const SUBSCRIBE_CREATE_PROJECT = 'newproject';
    protected $message = 'Создан новый проект';
    
    static public function register() {
        Event::on(Projects::class, Projects::EVENT_AFTER_INSERT, [static::class, 'handler']);
    }
    
    static public function handler($event) {
        (new static())->run($event);
    }
    
    public function run($event) {
        $subscribers = Subscription::getSubscriptions(static::SUBSCRIBE_CREATE_PROJECT);
        /* @var Subscription $subscriber */
        foreach ($subscribers as $subscriber){
            $this->bot->sendMessage($subscriber->chat->chat_id, $this->message);
        }
    }
    
}