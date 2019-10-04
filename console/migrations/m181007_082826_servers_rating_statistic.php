<?php

use yii\db\Migration;

/**
 * Class m181007_082826_servers_rating_statistic
 */
class m181007_082826_servers_rating_statistic extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('servers_rating_statistic', [
            'id' => $this->primaryKey(),
            'server_id' => $this->integer(11)->notNull(),
            'rating' => $this->float()->notNull(),
            'date' => $this->timestamp()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-servers_rating_statistic-server_id',
            'servers_rating_statistic',
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
        echo "m181007_082826_servers_rating_statistic cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181007_082826_servers_rating_statistic cannot be reverted.\n";

        return false;
    }
    */
}
