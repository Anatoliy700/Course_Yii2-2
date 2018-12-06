<?php

namespace common\components\telegram;


use SonkoDmitry\Yii\TelegramBot\Component;

/**
 * Class TelegramBase
 * @property Component $bot
 * @package common\components\telegram
 */
class TelegramBase extends \yii\base\Component
{
    private $_bot;
    
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
    
}