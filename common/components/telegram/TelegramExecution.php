<?php

namespace common\components\telegram;

use common\components\telegram\commands\CommandBase;
use common\components\telegram\commands\HelpCommand;
use common\components\telegram\commands\SubscribeCommand;
use common\components\telegram\commands\UnsubscribeCommand;
use common\components\telegram\models\Commands;
use common\components\telegram\models\Subscription;
use yii\helpers\ArrayHelper;

/**
 * Class TelegramExecution
 * @package common\components\telegram
 */
class TelegramExecution extends TelegramBase
{
    const INVALID_COMMAND_MESSAGE = 'Не корректная команда';
    
    protected $commands = [
        'help' => [
            'class' => HelpCommand::class,
            'description' => 'Выводит список доступных команд'
        ],
        'subscribe' => [
            'class' => SubscribeCommand::class,
            'description' => 'Подписаться'
        ],
        'unsubscribe' => [
            'class' => UnsubscribeCommand::class,
            'description' => 'Отписаться'
        ]
    ];
    
    public static function run() {
        $mod = new static();
        while (true) {
            $mod->execution();
            sleep(0.5);
        }
    }
    
    
    protected function execution() {
        $commands = Commands::getNotExecutedCommands();
        foreach ($commands as $commandActiveRecord) {
            /* @var Commands $commandActiveRecord */
            $command = $this->parseCommand($commandActiveRecord);
            
            if (ArrayHelper::keyExists($command['name'], $this->commands)) {
                /* @var CommandBase $commandExecutor */
//                $commandExecutor = \Yii::createObject($this->commands[$command['name']]['class']);
                $class = $this->commands[$command['name']]['class'];
                $commandExecutor = new $class($command);
                if ($command['name'] === 'help') {
                    $commandExecutor->setAttributes(['commands' => $this->commands]);
                } else {
                    $commandExecutor->setAttributes(['prams'=> $command]);
                }
                $commandExecutor->run();
                $responseMessage = $commandExecutor->getMessage();
            } else {
                $responseMessage = static::INVALID_COMMAND_MESSAGE;
            }
            $commandActiveRecord->done();
            $this->sendMessage($commandActiveRecord->chat_id, $responseMessage);
        }
        
    }
    
    protected function parseCommand(Commands $command) {
        $arr = explode(' ', trim($command->command));
        return [
            'name' => trim(array_shift($arr), '/'),
            'params' => array_unique($arr),
            'chat_id' => $command->chat_id,
        ];
    }
    
    protected function sendMessage($chatId, $message) {
        $this->bot->sendMessage($chatId, $message);
    }
    
}