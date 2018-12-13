<?php

use yii\db\Migration;

/**
 * Class m181211_121241_add_column_in_tasks_table
 */
class m181211_121241_add_column_in_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn(
            'tasks',
            'initiator_id',
            $this->integer()->notNull()->after('user_id')
        );
        $this->addColumn(
            'tasks',
            'done_date',
            $this->dateTime()->after('project_id')
        );
        $this->execute('SET FOREIGN_KEY_CHECKS=0;');
        $this->addForeignKey(
            'fk_tasks_initiator_id',
            'tasks',
            'initiator_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->execute('SET FOREIGN_KEY_CHECKS=1;');
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropForeignKey('fk_tasks_initiator_id', 'tasks');
        $this->dropColumn('tasks', 'initiator_id');
        $this->dropColumn('tasks', 'done_date');
    }
    
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181211_121241_add_column_in_tasks_table cannot be reverted.\n";

        return false;
    }
    */
}
