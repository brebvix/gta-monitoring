<?php

use yii\db\Migration;

/**
 * Class m181015_064134_telegram_bot
 */
class m181015_064134_telegram_bot extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('telegram_user', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->defaultValue('-1'),
            'telegram_user_id' => $this->integer(16)->notNull(),
            'chat_id' => $this->integer(16)->notNull(),
            'username' => $this->string(48)->notNull(),
            'first_name' => $this->string(48)->notNull(),
            'language' => $this->string(2)->notNull()->defaultValue('ru'),
            'last_update' => $this->timestamp()->notNull(),
        ]);

        $this->createTable('telegram_servers_relations', [
            'id' => $this->primaryKey(),
            'telegram_user_id' => $this->integer(11)->notNull(),
            'server_id' => $this->integer(11)->notNull(),
        ]);

        $this->addForeignKey(
            'fk-telegram_servers_relations-telegram_user_id',
            'telegram_servers_relations',
            'telegram_user_id',
            'telegram_user',
            'id'
        );

        $this->addForeignKey(
            'fk-telegram_servers_relations-server_id',
            'telegram_servers_relations',
            'server_id',
            'servers',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181015_064134_telegram_bot cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181015_064134_telegram_bot cannot be reverted.\n";

        return false;
    }
    */
}
