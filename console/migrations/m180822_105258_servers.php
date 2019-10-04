<?php

use yii\db\Migration;

/**
 * Class m180822_105258_servers
 */
class m180822_105258_servers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('servers', [
            'id' => $this->primaryKey(),
            'game_id' => $this->integer(11)->notNull(),
            'ip' => $this->string(15)->notNull(),
            'port' => $this->string(5)->notNull(),
            'title' => $this->string(64)->defaultValue(''),
            'title_eng' => $this->string(64)->defaultValue(''),
            'mode' => $this->string(32)->defaultValue(''),
            'language' => $this->string(32)->defaultValue(''),
            'version' => $this->string(12)->defaultValue(''),
            'site' => $this->string(32)->defaultValue(''),
            'players' => $this->integer(11)->notNull()->defaultValue(0),
            'maxplayers' => $this->integer(11)->notNull()->defaultValue(0),
            'average_online' => $this->integer(11)->notNull()->defaultValue(0),
            'maximum_online' => $this->integer(11)->notNull()->defaultValue(0),
            'offline_count' => $this->integer(1)->notNull()->defaultValue(0),
            'rating' => $this->float()->notNull()->defaultValue(2.7),
            'rating_up' => $this->integer(11)->defaultValue(1),
            'rating_down' => $this->integer(11)->defaultValue(0),
            'created_at' => $this->timestamp()->notNull(),
            'status' => $this->integer(1)->notNull()->defaultValue(0),
        ]);

        $this->addForeignKey(
            'fk-servers-game_id',
            'servers',
            'game_id',
            'games',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180822_105258_servers cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180822_105258_servers cannot be reverted.\n";

        return false;
    }
    */
}
