<?php

use yii\db\Migration;

/**
 * Class m181130_150006_add_column_project_id_and_status_id_in_tasks_table
 */
class m181130_150006_add_column_project_id_and_status_id_in_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        
        $this->addColumn(
            'tasks',
            'project_id',
            $this->integer()->notNull()->after('user_id')
        );
        
        $this->addColumn(
            'tasks',
            'status_id',
            $this->integer()->notNull()->after('user_id')
        );
        
        
        $this->addForeignKey(
            'fk_tasks_project_id',
            'tasks',
            'project_id',
            'projects',
            'id',
            'CASCADE',
            'CASCADE'
        );
        
        $this->addForeignKey(
            'fk_tasks_status_id',
            'tasks',
            'status_id',
            'task_statuses',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropForeignKey('fk_tasks_project_id', 'tasks');
        $this->dropForeignKey('fk_tasks_status_id', 'tasks');
        
        $this->dropColumn('tasks', 'project_id');
        $this->dropColumn('tasks', 'status_id');
    }
    
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181130_150006_add_column_project_id_and_status_id_in_tasks_table cannot be reverted.\n";

        return false;
    }
    */
}
