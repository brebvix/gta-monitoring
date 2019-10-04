<?php

use yii\db\Migration;

/**
 * Class m180829_072843_user_payments
 */
class m180829_072843_user_payments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_payments', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'amount_rub' => $this->float()->notNull(),
            'amount_usd' => $this->float()->notNull(),
            'date' => $this->timestamp()->notNull(),
            'status' => $this->integer(1)->notNull()->defaultValue(0),
        ]);

        $this->addForeignKey(
            'fk-user_payments-user_id',
            'user_payments',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180829_072843_user_payments cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180829_072843_user_payments cannot be reverted.\n";

        return false;
    }
    */
}
