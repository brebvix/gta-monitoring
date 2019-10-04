<?php

use yii\db\Migration;

/**
 * Class m180906_124934_server_description
 */
class m180906_124934_server_description extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('servers', 'description', $this->text());

        $this->createTable('servers_description', [
            'id' => $this->primaryKey(),
            'server_id' => $this->integer(11)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
            'description' => $this->text()->notNull(),
            'date' => $this->timestamp()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-servers_description-server_id',
            'servers_description',
            'server_id',
            'servers',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-servers_description-user_id',
            'servers_description',
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
        echo "m180906_124934_server_description cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180906_124934_server_description cannot be reverted.\n";

        return false;
    }
    */
}
