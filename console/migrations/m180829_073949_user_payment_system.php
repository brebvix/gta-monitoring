<?php

use yii\db\Migration;

/**
 * Class m180829_073949_user_payment_system
 */
class m180829_073949_user_payment_system extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_payments', 'payment_system', $this->string(24)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180829_073949_user_payment_system cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180829_073949_user_payment_system cannot be reverted.\n";

        return false;
    }
    */
}
