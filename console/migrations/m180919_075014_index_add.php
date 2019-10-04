<?php

use yii\db\Migration;

/**
 * Class m180919_075014_index_add
 */
class m180919_075014_index_add extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-servers-ip',
            'servers',
            'ip'
        );

        $this->createIndex(
            'idx-players-nickname',
            'players',
            'nickname'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180919_075014_index_add cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180919_075014_index_add cannot be reverted.\n";

        return false;
    }
    */
}
