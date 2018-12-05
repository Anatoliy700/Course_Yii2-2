<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_chat`.
 */
class m181204_180853_create_user_chat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('user_chat', [
            'user_id' => $this->primaryKey(),
            'chat_id' => $this->integer(20)->notNull(),
        ]);
        
        $this->createIndex(
            'idx_user_chat_chat_id',
            'user_chat',
            'chat_id',
            true
        );
        
        $this->addForeignKey(
            'fk_user_chat_user_id',
            'user_chat',
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
        $this->dropTable('user_chat');
    }
}
