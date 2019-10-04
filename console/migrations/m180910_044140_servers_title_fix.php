<?php

use yii\db\Migration;

/**
 * Class m180910_044140_servers_title_fix
 */
class m180910_044140_servers_title_fix extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('servers', 'title', $this->string(128));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180910_044140_servers_title_fix cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180910_044140_servers_title_fix cannot be reverted.\n";

        return false;
    }
    */
}
