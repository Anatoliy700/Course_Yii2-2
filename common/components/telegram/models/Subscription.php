<?php

namespace common\components\telegram\models;


use common\models\search\SubscriptionsSearch;
use common\models\tables\Subscriptions;
use common\models\tables\UserChat;
use yii\base\Model;

class Subscription extends Model
{
    public $chat_id;
    public $subscribe_name;
    
    public function rules() {
        return [
            [['chat_id', 'subscribe_name'], 'require'],
            [['chat_id'], 'integer', 'max' => 11],
            [['subscribe_name'], 'string', 'max' => 20]
        ];
    }
    
    
    public function getUserIdByChatId() {
        return UserChat::find()->where(['chat_id' => $this->chat_id])->one()->user_id;
    }
    
    public function save() {
        $subscribe = new Subscriptions();
        $subscribe->setAttributes([
            'user_id' => $this->getUserIdByChatId(),
            'subscribe_name' => $this->subscribe_name
        ]);
        if ($subscribe->save()) {
            return true;
        } else {
            $this->addErrors($subscribe->errors);
            return false;
        }
    }
    
    public function delete() {
        $subscribe = Subscriptions::findOne([
            'user_id' => $this->getUserIdByChatId(),
            'subscribe_name' => $this->subscribe_name
        ]);
        if (!is_null($subscribe)) {
            return $subscribe->delete();
        }
        return false;
    }
    
    static public function getSubscriptions($subscription, $user_id = null) {
        return Subscriptions::find()
            ->where(['subscribe_name' => $subscription])
            ->andFilterWhere(['user_id' => $user_id])
            ->with('chat')
            ->all();
    }
}