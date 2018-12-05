<?php

namespace common\components\telegram;


use common\components\telegram\models\Commands;
use SonkoDmitry\Yii\TelegramBot\Component;
use TelegramBot\Api\Types\Update;

/**
 * Class TelegramReceive
 * @property Component $bot
 * @property integer $offset
 * @package app\console\models
 */
class TelegramReceive extends TelegramBase
{
    private $_offset;
    
    public static function run() {
        $mod = new static();
        while (true) {
            $messages = $mod->bot->getUpdates($mod->offset);
            if (count($messages) > 0) {
                $mod->save($messages);
            }
            sleep(0.5);
        }
    }
    
    protected function getOffset() {
        
        if (is_null($this->_offset)) {
            $lastId = Commands::getLastId();
            if ($lastId > 0) {
                $this->offset = $lastId;
            } else {
                $this->_offset = 0;
            }
        }
        return $this->_offset;
    }
    
    protected function setOffset($offset) {
        $this->_offset = $offset + 1;
    }
    
    protected function save(array $messages) {
        /* @var Update $message */
        foreach ($messages as $message) {
            $updateId = $message->getUpdateId();
            $command = [
                'update_id' => $updateId,
                'command' => $message->getMessage()->getText(),
                'chat_id' => $message->getMessage()->getChat()->getId(),
                'date' => $message->getMessage()->getDate(),
            ];
            $model = new Commands($command);
            if ($model->save()) {
                $this->offset = $updateId;
            } else {
                var_dump($model->getErrors());
            }
            echo "Message: {$message->getMessage()->getText()} "
                . "from: {$message->getMessage()->getFrom()->getUsername()}" . PHP_EOL;
        }
        
    }
    
}