<?php

use yii\db\Migration;

/**
 * Class m181016_094440_user_telegram
 */
class m181016_094440_user_telegram extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'telegram_status', $this->integer(1)->notNull()->defaultValue(0));
        $this->addColumn('user', 'telegram_user_id', $this->integer(16)->notNull()->defaultValue(-1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181016_094440_user_telegram cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181016_094440_user_telegram cannot be reverted.\n";

        return false;
    }
    */
}
