<?php

use yii\db\Migration;

/**
 * Handles the creation of table `subscriptions`.
 */
class m181204_162153_create_subscriptions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('subscriptions', [
            'user_id' => $this->integer()->notNull(),
            'subscribe_name' => $this->string(20)->notNull(),
        ]);
        
        $this->createIndex(
            'idx_subscriptions_user_id_subscribe_name',
            'subscriptions',
            ['user_id', 'subscribe_name'],
            true
        );
        
        $this->addForeignKey(
            'fk_subscriptions_user_id',
            'subscriptions',
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
        $this->dropTable('subscriptions');
    }
}
