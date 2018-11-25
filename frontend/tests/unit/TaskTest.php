<?php namespace frontend\tests;

use common\models\tables\Users;
use frontend\models\Task;

class TaskTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;
    
    protected function _before() {
    }
    
    protected function _after() {
    }
    
    public function testValidationDate() {
        $task = new Task();
        
        $task->date = null;
        $this->assertTrue($task->validate(['date']));
        
        $task->date = date('Y-m-d');
        $this->assertTrue($task->validate(['date']));
        
        $task->date = date('Y-m-d', strtotime('-1 day'));
        $this->assertFalse($task->validate(['date']));
        
        $task->date = date('d-m-Y');
        $this->assertFalse($task->validate(['date']));
        
        $task->date = 123456;
        $this->assertFalse($task->validate(['date']));
    }
    
    /* public function testCorrectFillingOfEmptyDate(){
         $task = new Task();
         $task->save();
         $this->assertEquals(date('Y-m-d'), $task->date);
     }*/
    public function testValidationTitle() {
        $task = new Task();
        
        $task->title = null;
        $this->assertFalse($task->validate(['title']));
        
        $task->title = 123456;
        $this->assertFalse($task->validate(['title']));
        
        $task->title = 'qwer';
        $this->assertFalse($task->validate(['title']));
        
        $task->title = 'qwertyuiopa';
        $this->assertFalse($task->validate(['title']));
        
        $task->title = 'qwertyuiop';
        $this->assertTrue($task->validate(['title']));
    }
    
    public function testValidationDescription() {
        $task = new Task();
        
        $task->description = null;
        $this->assertFalse($task->validate(['description']));
        
        $task->description = 123456;
        $this->assertFalse($task->validate(['description']));
        
        $task->description = 'qwer';
        $this->assertFalse($task->validate(['description']));
        
        $task->description = 'qwertyuiopa';
        $this->assertTrue($task->validate(['description']));
    }
    
    public function testValidationUser_id() {
        $task = new Task();
        
        $task->user_id = null;
        $this->assertFalse($task->validate(['user_id']));
        
        $task->user_id = 0;
        $this->assertFalse($task->validate(['user_id']));
        
        $task->user_id = 'qwer';
        $this->assertFalse($task->validate(['user_id']));
        
        $task->user_id = '1';
        $this->assertTrue($task->validate(['user_id']));
    }
}