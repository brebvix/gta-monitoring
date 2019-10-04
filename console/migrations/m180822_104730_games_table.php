<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m180822_104730_games_table
 */
class m180822_104730_games_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('games', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()
        ]);

        $this->insert('games', [
            'title' => 'SAMP',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180822_104730_games_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180822_104730_games_table cannot be reverted.\n";

        return false;
    }
    */
}
