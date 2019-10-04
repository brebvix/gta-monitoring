<?php

use yii\db\Migration;

/**
 * Class m180907_085821_user_favorite_servers
 */
class m180907_085821_user_favorite_servers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_favorite_servers', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'server_id' => $this->integer(11)->notNull()
        ]);

        $this->addForeignKey(
            'fk-user_favorite_servers-server_id',
            'user_favorite_servers',
            'server_id',
            'servers',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-user_favorite_servers-user_id',
            'user_favorite_servers',
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
        echo "m180907_085821_user_favorite_servers cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180907_085821_user_favorite_servers cannot be reverted.\n";

        return false;
    }
    */
}
