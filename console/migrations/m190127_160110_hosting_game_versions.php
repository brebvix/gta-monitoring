<?php

use yii\db\Migration;

/**
 * Class m190127_160110_hosting_game_versions
 */
class m190127_160110_hosting_game_versions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('hosting_games_versions', [
            'id' => $this->primaryKey(),
            'game_id' => $this->integer(11)->notNull(),
            'title' => $this->string(32)->notNull(),
            'archive' => $this->string(32)->notNull()
        ]);

        $this->addForeignKey(
            'fk-hosting_games_versions-game_id',
            'hosting_games_versions',
            'game_id',
            'hosting_games',
            'id'
        );

        $this->addColumn('hosting_servers', 'version_id', $this->integer(11)->notNull());

        $this->addForeignKey(
            'fk-hosting_servers-version_id',
            'hosting_servers',
            'version_id',
            'hosting_games_versions',
            'id'
        );

        $this->insert('hosting_games', [
            'title' => 'GTA: Criminal Russia',
            'short' => 'CRMP',
            'min_slots' => 50,
            'max_slots' => 1000,
            'start_port' => 7000,
            'end_port' => 7999,
            'price' => 1.5,
            'price_type' => 0
        ]);

        $this->insert('hosting_games_versions', [
            'game_id' => 1,
            'title' => 'SA-MP 0.3.7 R2-1',
            'archive' => 'samp037svr_R2-1.tar.gz'
        ]);

        $this->insert('hosting_games_versions', [
            'game_id' => 1,
            'title' => 'SA-MP 0.3DL R1',
            'archive' => 'samp03DLsvr_R1.tar.gz'
        ]);

        $this->insert('hosting_games_versions', [
            'game_id' => 2,
            'title' => 'CR-MP 0.3.7 C5 (2.4)',
            'archive' => 'srv-cr-mp-c5-linux.tar.gz'
        ]);

        $this->insert('hosting_games_versions', [
            'game_id' => 2,
            'title' => 'CR-MP 0.3E C3',
            'archive' => 'srv-cr-mp-c3-linux.tar.gz'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190127_160110_hosting_game_versions cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190127_160110_hosting_game_versions cannot be reverted.\n";

        return false;
    }
    */
}
