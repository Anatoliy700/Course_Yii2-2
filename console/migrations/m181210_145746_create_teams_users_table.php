<?php

use yii\db\Migration;

/**
 * Handles the creation of table `teams_users`.
 */
class m181210_145746_create_teams_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('teams_users', [
            'id' => $this->primaryKey(),
            'team_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ], $tableOptions);
        
        $this->addForeignKey(
            'fk_team_users_team_id',
            'teams_users',
            'team_id',
            'teams',
            'id',
            'CASCADE',
            'CASCADE'
        );
        
        $this->addForeignKey(
            'fk_team_users_user_id',
            'teams_users',
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
        $this->dropTable('teams_users');
    }
}
