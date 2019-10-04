<?php

use yii\db\Migration;

/**
 * Class m180909_111002_new_games
 */
class m180909_111002_new_games extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('games', ['id' => 4, 'title' => 'MTA']);
        $this->insert('games', ['id' => 5, 'title' => 'Minecraft']);
        $this->insert('games', ['id' => 6, 'title' => 'Rust']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180909_111002_new_games cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180909_111002_new_games cannot be reverted.\n";

        return false;
    }
    */
}
