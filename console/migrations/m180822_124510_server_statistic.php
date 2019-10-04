<?php

use yii\db\Migration;

/**
 * Class m180822_124510_server_statistic
 */
class m180822_124510_server_statistic extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('servers_statistic', [
            'id' => $this->primaryKey(),
            'server_id' => $this->integer(11)->notNull(),
            'date' => $this->timestamp()->notNull(),
            'players' => $this->integer(11)->notNull(),
        ]);

        $this->addForeignKey(
            'fk-servers_statistic-server_id',
            'servers_statistic',
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
        echo "m180822_124510_server_statistic cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180822_124510_server_statistic cannot be reverted.\n";

        return false;
    }
    */
}
