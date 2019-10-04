<?php

use yii\db\Migration;

/**
 * Class m180822_124817_server_statistic_month
 */
class m180822_124817_server_statistic_month extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('servers_statistic_month', [
            'id' => $this->primaryKey(),
            'server_id' => $this->integer(11)->notNull(),
            'date' => $this->timestamp()->notNull(),
            'average_online' => $this->integer(11)->defaultValue(0),
            'maximum_online' => $this->integer(11)->defaultValue(0)
        ]);

        $this->addForeignKey(
            'fk-servers_statistic_month-server_id',
            'servers_statistic_month',
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
        echo "m180822_124817_server_statistic_month cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180822_124817_server_statistic_month cannot be reverted.\n";

        return false;
    }
    */
}
