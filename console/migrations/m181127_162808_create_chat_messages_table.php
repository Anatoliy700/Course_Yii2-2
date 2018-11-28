<?php

use yii\db\Migration;

/**
 * Handles the creation of table `chat_messages`.
 */
class m181127_162808_create_chat_messages_table extends Migration
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
        
        $this->createTable('chat_messages', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'message' => $this->string(255)->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ], $tableOptions);
        
        $this->addForeignKey(
            'fk_chat_messages_task_id',
            'chat_messages',
            'task_id',
            'tasks',
            'id',
            'CASCADE',
            'CASCADE'
        );
        
        $this->addForeignKey(
            'fk_chat_messages_user_id',
            'chat_messages',
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );
        
        $this->createIndex(
            'idx_chat_messages_task_id',
            'chat_messages',
            'task_id'
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('chat_messages');
    }
}
