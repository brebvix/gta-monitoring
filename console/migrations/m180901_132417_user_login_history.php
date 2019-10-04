<?php

use yii\db\Migration;

/**
 * Class m180901_132417_user_login_history
 */
class m180901_132417_user_login_history extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_login_history', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'ip' => $this->string(15)->notNull(),
            'date' => $this->timestamp(11)->notNull(),
        ]);

        $this->addForeignKey(
            'fk-user_login_history-user_id',
            'user_login_history',
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
        echo "m180901_132417_user_login_history cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180901_132417_user_login_history cannot be reverted.\n";

        return false;
    }
    */
}
