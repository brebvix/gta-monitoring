<?php

use yii\db\Migration;

/**
 * Class m181011_112941_global_statistic
 */
class m181011_112941_global_statistic extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('system', [
            'id' => 2,
            'key' => 'servers_count',
            'value' => 0
        ]);

        $this->insert('system', [
            'id' => 3,
            'key' => 'servers_online',
            'value' => 0,
        ]);

        $this->insert('system', [
            'id' => 4,
            'key' => 'players_online',
            'value' => 0,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181011_112941_global_statistic cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181011_112941_global_statistic cannot be reverted.\n";

        return false;
    }
    */
}
