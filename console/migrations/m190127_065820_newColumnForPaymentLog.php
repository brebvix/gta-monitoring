<?php

use yii\db\Migration;

/**
 * Class m190127_065820_newColumnForPaymentLog
 */
class m190127_065820_newColumnForPaymentLog extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_payments', 'type', $this->integer(1)->notNull()->defaultValue(0));
        $this->addColumn('user_payments', 'comment', $this->string(64)->notNull()->defaultValue(''));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190127_065820_newColumnForPaymentLog cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190127_065820_newColumnForPaymentLog cannot be reverted.\n";

        return false;
    }
    */
}
