<?php

use yii\db\Migration;

/**
 * Class m180830_090934_vip_servers_fix
 */
class m180830_090934_vip_servers_fix extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('servers_vip', 'status', $this->integer(1)->notNull());
        $this->addColumn('servers_vip', 'type', $this->integer(1)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180830_090934_vip_servers_fix cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180830_090934_vip_servers_fix cannot be reverted.\n";

        return false;
    }
    */
}
