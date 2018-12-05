<?php

namespace common\components\telegram\commands;


class HelpCommand extends CommandBase
{
    protected $commands;
    
    public function __construct(array $config = []) {
        $this->commands = $config;
        parent::__construct();
    }
    
    
    public function rules() {
        return [
            [['commands'], 'safe'],
        ];
    }
    
    
    static public function getExpectedParams(): array {
        return [];
    }
    
    public function run() {
        $this->message = $this->getString($this->commands);
    }
    
    protected function getString(array $arr, $prefix = 'command - /', $emptyLine = true) {
        $string = '';
        foreach ($arr as $key => $item) {
            $string .= "{$prefix}{$key} - " . ($item['description'] ?: '') . PHP_EOL;
            
            if (isset($item['class'])) {
                $expectedParams = $item['class']::getExpectedParams();
                if (count($expectedParams) > 0) {
                    $string .= $this->getString($expectedParams, 'param - ', false);
                    $string .= "Пример: {$item['name']} param [param]" . PHP_EOL;
                }
            }
            if ($emptyLine) {
                $string .= PHP_EOL;
            }
        }
        return $string;
    }
    
}