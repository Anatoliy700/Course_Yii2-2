<?php

use yii\db\Migration;

/**
 * Handles the creation of table `project_statuses`.
 */
class m181130_095017_create_project_statuses_table extends Migration
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
        
        $this->createTable('project_statuses', [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ], $tableOptions);
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('project_statuses');
    }
}
