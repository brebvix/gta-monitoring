<?php

use yii\db\Migration;

/**
 * Class m180830_084803_vip_servers
 */
class m180830_084803_vip_servers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('servers', 'background', $this->string(32)->defaultValue(''));
        $this->addColumn('servers', 'vip', $this->integer(1)->defaultValue(0));

        $this->createTable('servers_vip', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'server_id' => $this->integer(11)->notNull(),
            'days' => $this->integer(6)->notNull(),
            'date' => $this->timestamp()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-servers_vip-user_id',
            'servers_vip',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-servers_vip-server_id',
            'servers_vip',
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
        echo "m180830_084803_vip_servers cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180830_084803_vip_servers cannot be reverted.\n";

        return false;
    }
    */
}
