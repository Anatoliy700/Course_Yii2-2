<?php

use yii\db\Migration;

/**
 * Class m181219_161149_add_column_tasks_table
 */
class m181219_161149_add_column_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('tasks', 'report', $this->string(255)->after('done_date'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropColumn('tasks', 'report');
    }
    
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181219_161149_add_column_tasks_table cannot be reverted.\n";

        return false;
    }
    */
}
