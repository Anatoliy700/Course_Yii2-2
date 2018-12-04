<?php

namespace common\components\telegram;


use common\models\tables\TelegramCommands;
use SonkoDmitry\Yii\TelegramBot\Component;
use TelegramBot\Api\Types\Update;

/**
 * Class TelegramReceive
 * @property Component $bot
 * @property integer $offset
 * @package app\console\models
 */
class TelegramReceive extends \yii\base\Component
{
    private $_bot;
    private $_offset;
    
    public function init() {
        parent::init();
        $this->setSetting();
    }
    
    
    protected function setSetting() {
        \Yii::$app->db->createCommand('SET SESSION wait_timeout = 28800;')->execute();
    
        $this->bot->setProxy('178.238.227.29:3128');
        $this->bot->setCurlOption(CURLOPT_HTTPHEADER, array('Expect:'));
        $this->bot->setCurlOption(CURLOPT_CONNECTTIMEOUT, 10);
        $this->bot->setCurlOption(CURLOPT_TIMEOUT, 10);
        $this->bot->setCurlOption(CURLOPT_FOLLOWLOCATION, false);
    }
    
    protected function getBot() {
        if (is_null($this->_bot)) {
            $this->_bot = \Yii::$app->bot;
        }
        return $this->_bot;
    }
    
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
            $max = TelegramCommands::find()->max('update_id');
            if ($max > 0) {
                $this->offset = $max;
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
            $model = new TelegramCommands($command);
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