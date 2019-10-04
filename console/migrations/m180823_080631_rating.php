<?php

use yii\db\Migration;

/**
 * Class m180823_080631_rating
 */
class m180823_080631_rating extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('servers_rating', [
            'id' => $this->primaryKey(),
            'server_id' => $this->integer(11)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
            'date' => $this->timestamp()->notNull(),
            'type' => $this->integer(1)->notNull()
        ]);

        $this->addForeignKey(
            'fk-servers_rating-server_id',
            'servers_rating',
            'server_id',
            'servers',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-servers_rating-user_id',
            'servers_rating',
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
        echo "m180823_080631_rating cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180823_080631_rating cannot be reverted.\n";

        return false;
    }
    */
}
