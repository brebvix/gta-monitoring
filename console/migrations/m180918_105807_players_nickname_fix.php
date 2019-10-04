<?php

use yii\db\Migration;

/**
 * Class m180918_105807_players_nickname_fix
 */
class m180918_105807_players_nickname_fix extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    	$this->alterColumn('players', 'nickname', $this->string(32)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180918_105807_players_nickname_fix cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180918_105807_players_nickname_fix cannot be reverted.\n";

        return false;
    }
    */
}
