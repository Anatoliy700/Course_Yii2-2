<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tasks`.
 */
class m181116_184852_create_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
    
        $this->createTable('tasks', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->notNull(),
            'description' => $this->string(255)->notNull(),
            'date' => $this->date()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ], $tableOptions);
        $this->createIndex(
            'idx-tasks-title',
            'tasks',
            'title'
        );
        $this->createIndex(
            'idx-tasks-date',
            'tasks',
            'date'
        );
        $this->addForeignKey(
            'fk-tasks-user_id',
            'tasks',
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('tasks');
    }
}
