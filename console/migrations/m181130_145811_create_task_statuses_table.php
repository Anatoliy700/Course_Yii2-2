<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task_statuses`.
 */
class m181130_145811_create_task_statuses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('task_statuses', [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ], $tableOptions);
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('task_statuses');
    }
}
