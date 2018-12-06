<?php

namespace common\components\telegram\eventHandlers;


use common\components\telegram\models\Subscription;
use common\components\telegram\TelegramBase;
use common\models\tables\Tasks;
use yii\base\Event;

class CreateTask extends TelegramBase
{
    const SUBSCRIBE_CREATE_TASK = 'newtask';
    protected $message = 'Вам поставлена задача';
    
    static public function register() {
        Event::on(Tasks::class, Tasks::EVENT_AFTER_INSERT, [static::class, 'handler']);
    }
    
    static public function handler($event) {
        (new static())->run($event);
    }
    
    public function run($event) {
        $subscribers = Subscription::getSubscriptions(static::SUBSCRIBE_CREATE_TASK, $event->sender->user_id);
        /* @var Subscription $subscriber */
        foreach ($subscribers as $subscriber) {
            $this->bot->sendMessage($subscriber->chat->chat_id, $this->message);
        }
    }
    
}