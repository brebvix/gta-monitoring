<?php

use yii\db\Migration;

/**
 * Class m180910_042914_game_ragemp
 */
class m180910_042914_game_ragemp extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('games', [
            'id' => 7,
            'title' => 'RAGE Multiplayer',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180910_042914_game_ragemp cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180910_042914_game_ragemp cannot be reverted.\n";

        return false;
    }
    */
}
