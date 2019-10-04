<?php

use yii\db\Migration;

/**
 * Class m180828_120346_service_status
 */
class m180828_120346_service_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('freelance_services', 'status', $this->integer(11)->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180828_120346_service_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180828_120346_service_status cannot be reverted.\n";

        return false;
    }
    */
}
