<?php

namespace common\components\telegram\eventHandlers;


use common\components\telegram\models\Subscription;
use common\components\telegram\TelegramBase;
use common\models\tables\Projects;
use yii\base\Event;

class UpdateProject extends TelegramBase
{
    const SUBSCRIBE_UPDATE_PROJECT = 'updateproject';
    protected $message = 'Обновление проекта';
    
    static public function register() {
        Event::on(Projects::class, Projects::EVENT_AFTER_INSERT, [static::class, 'handler']);
    }
    
    static public function handler($event) {
        (new static())->run($event);
    }
    
    public function run($event) {
        $subscribers = Subscription::getSubscriptions(static::SUBSCRIBE_UPDATE_PROJECT);
        /* @var Subscription $subscriber */
        foreach ($subscribers as $subscriber) {
            $this->bot->sendMessage($subscriber->chat->chat_id, $this->message);
        }
    }
    
}