<?php

use yii\db\Migration;

/**
 * Handles the creation of table `projects`.
 */
class m181130_095026_create_projects_table extends Migration
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
        
        $this->createTable('projects', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'user_id' => $this->integer()->notNull(),
            'status_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ], $tableOptions);
        
        $this->addForeignKey(
            'fk_projects_user_id',
            'projects',
            'user_id',
            'users',
            'id'
        );
        
        $this->addForeignKey(
            'fk_projects_status_id',
            'projects',
            'status_id',
            'project_statuses',
            'id'
        );
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('projects');
    }
}
