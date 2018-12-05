<?php

use yii\db\Migration;

/**
 * Handles the creation of table `telegram_commands`.
 */
class m181203_133854_create_telegram_commands_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('telegram_commands', [
            'update_id' => $this->integer()->notNull(),
            'command' => $this->string(255)->notNull(),
            'chat_id' => $this->integer(20)->notNull(),
            'done' => $this->boolean()->notNull()->defaultValue(false),
            'date' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);
        
        $this->createIndex('idx_telegram_commands_id', 'telegram_commands', 'update_id', true);
        $this->addPrimaryKey('primary_telegram_commands_id', 'telegram_commands', 'update_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('telegram_commands');
    }
}
