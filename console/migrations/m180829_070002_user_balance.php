<?php

use yii\db\Migration;

/**
 * Class m180829_070002_user_balance
 */
class m180829_070002_user_balance extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'balance', $this->float()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180829_070002_user_balance cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180829_070002_user_balance cannot be reverted.\n";

        return false;
    }
    */
}
