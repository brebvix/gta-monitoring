<?php

use yii\db\Migration;

/**
 * Class m190126_105840_server_top_field
 */
class m190126_105840_server_top_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('servers', 'top' , $this->integer(1)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190126_105840_server_top_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190126_105840_server_top_field cannot be reverted.\n";

        return false;
    }
    */
}
