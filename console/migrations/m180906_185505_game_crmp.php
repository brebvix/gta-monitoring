<?php

use yii\db\Migration;

/**
 * Class m180906_185505_game_crmp
 */
class m180906_185505_game_crmp extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('games', [
            'id' => 2,
            'title' => 'CRMP'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180906_185505_game_crmp cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180906_185505_game_crmp cannot be reverted.\n";

        return false;
    }
    */
}
