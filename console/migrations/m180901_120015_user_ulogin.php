<?php

use yii\db\Migration;

/**
 * Class m180901_120015_user_ulogin
 */
class m180901_120015_user_ulogin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_ulogin', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull()->unique(),
            'identity' => $this->string(128)->notNull(),
            'network' => $this->string(32)->notNull(),
            'date' => $this->timestamp()->notNull()

        ]);

        $this->addForeignKey(
            'fk-user_ulogin-user_id',
            'user_ulogin',
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
        echo "m180901_120015_user_ulogin cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180901_120015_user_ulogin cannot be reverted.\n";

        return false;
    }
    */
}
