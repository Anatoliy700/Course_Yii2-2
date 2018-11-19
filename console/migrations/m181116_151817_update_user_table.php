<?php

use yii\db\Migration;

/**
 * Class m181116_151817_update_table_user
 */
class m181116_151817_update_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->renameTable('user', 'users');
        $this->addColumn(
            'users',
            'first_name',
            $this->string(70)->after('username')
        );
        $this->addColumn(
            'users',
            'last_name',
            $this->string(70)->after('first_name')
        );
        $this->addColumn(
            'users',
            'role_id',
            $this->integer()->after('last_name')
        );
        
        $this->alterColumn('users', 'created_at', $this->dateTime()->notNull());
        $this->alterColumn('users', 'updated_at', $this->dateTime()->notNull());
        
        $this->createIndex(
            'idx-users-username',
            'users',
            'username'
        );
        $this->addForeignKey(
            'fk-users-role_id',
            'users',
            'role_id',
            'roles',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropForeignKey('fk-users-role_id', 'users');
        $this->dropIndex('idx-users-username', 'users');
        $this->dropColumn('users', 'role_id');
        $this->dropColumn('users', 'last_name');
        $this->dropColumn('users', 'first_name');
        $this->renameTable('users', 'user');
    }
    
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181116_151817_update_table_user cannot be reverted.\n";

        return false;
    }
    */
}
