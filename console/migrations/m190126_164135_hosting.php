<?php

use yii\db\Migration;

/**
 * Class m190126_164135_hosting
 */
class m190126_164135_hosting extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('hosting_games', [
            'id' => $this->primaryKey(),
            'title' => $this->string(32)->notNull(),
            'short' => $this->string(32)->notNull(),
            'min_slots' => $this->integer(5)->notNull(),
            'max_slots' => $this->integer(5)->notNull(),
            'start_port' => $this->integer(4)->notNull(),
            'end_port' => $this->integer(5)->notNull(),
            'price' => $this->float(5)->notNull(),
            'price_type' => $this->integer(1)->notNull()->defaultValue(0)
        ]);

        $this->createTable('hosting_locations', [
            'id' => $this->primaryKey(),
            'title' => $this->string(32)->notNull(),
            'ip' => $this->string(15)->notNull(),
            'username' => $this->string(32)->notNull(),
            'password' => $this->string(32)->notNull(),
            'status' => $this->integer(1)->notNull()->defaultValue(1)
        ]);

        $this->createTable('hosting_servers', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'game_id' => $this->integer(11)->notNull(),
            'location_id' => $this->integer(11)->notNull(),
            'port' => $this->integer(5)->notNull(),
            'slots' => $this->integer(5)->notNull(),
            'ftp_password' => $this->string(32)->notNull(),
            'database_password' => $this->string(32)->notNull(),
            'cpu_load' => $this->float(5)->notNull()->defaultValue(0),
            'ram_load' => $this->float(5)->notNull()->defaultValue(0),
            'start_date' => $this->timestamp()->notNull(),
            'end_date' => $this->timestamp()->notNull(),
            'status' => $this->integer(1)->defaultValue(0)
        ]);

        $this->addForeignKey(
            'fk-hosting_servers-user_id',
            'hosting_servers',
            'user_id',
            'user',
            'id'
        );

        $this->addForeignKey(
            'fk-hosting_servers-game_id',
            'hosting_servers',
            'game_id',
            'hosting_games',
            'id'
        );

        $this->addForeignKey(
            'fk-hosting_servers-location_id',
            'hosting_servers',
            'location_id',
            'hosting_locations',
            'id'
        );

        $this->insert('hosting_games', [
            'id' => 1,
            'title' => 'San Andreas MultiPlayer',
            'short' => 'SAMP',
            'min_slots' => 50,
            'max_slots' => 1000,
            'start_port' => 7000,
            'end_port' => 7999,
            'price' => 1.5,
            'price_type' => 0
        ]);

        $this->insert('hosting_locations', [
            'title' => 'Москва, Россия',
            'ip' => '194.58.118.252',
            'username' => 'root',
            'password' => 't5_VY2xyxrthWY',
            'status' => 1
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190126_164135_hosting cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190126_164135_hosting cannot be reverted.\n";

        return false;
    }
    */
}
