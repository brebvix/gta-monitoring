<?php

use yii\db\Migration;

/**
 * Class m180918_071342_players_statistic
 */
class m180918_071342_players_statistic extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('players', [
            'id' => $this->primaryKey(),
            'nickname' => $this->string(32)->notNull()->unique(),
            'nickname_eng' => $this->string(48)->notNull(),
            'minutes' => $this->integer(11)->notNull()->defaultValue(0),
            'date' => $this->timestamp()->notNull(),
        ]);

        $this->createTable('players_relations', [
            'id' => $this->primaryKey(),
            'player_id' => $this->integer(11)->notNull(),
            'server_id' => $this->integer(11)->notNull(),
            'minutes' => $this->integer(11)->notNull()->defaultValue(0),
            'date' => $this->timestamp()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-players_relations-player_id',
            'players_relations',
            'player_id',
            'players',
            'id'
        );

        $this->addForeignKey(
            'fk-players_relations-server_id',
            'players_relations',
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
        echo "m180918_071342_players_statistic cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180918_071342_players_statistic cannot be reverted.\n";

        return false;
    }
    */
}
