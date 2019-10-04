<?php

use yii\db\Migration;

/**
 * Class m180822_110458_servers_owner
 */
class m180822_110458_servers_owner extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('servers_owner', [
           'id' => $this->primaryKey(),
           'user_id' => $this->integer(11)->notNull(),
           'server_id' => $this->integer(11)->notNull(),
        ]);

        $this->addForeignKey(
            'fk-servers_owner-user_id',
            'servers_owner',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-servers_owner-server_id',
            'servers_owner',
            'server_id',
            'servers',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180822_110458_servers_owner cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180822_110458_servers_owner cannot be reverted.\n";

        return false;
    }
    */
}
