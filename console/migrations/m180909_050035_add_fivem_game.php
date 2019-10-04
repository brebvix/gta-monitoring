<?php

use yii\db\Migration;

/**
 * Class m180909_050035_add_fivem_game
 */
class m180909_050035_add_fivem_game extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('games', [
            'id' => 3,
            'title' => 'FiveM',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180909_050035_add_fivem_game cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180909_050035_add_fivem_game cannot be reverted.\n";

        return false;
    }
    */
}
