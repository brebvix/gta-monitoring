<?php

use yii\db\Migration;

/**
 * Class m181009_132111_servers_views
 */
class m181009_132111_servers_views extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('servers', 'views', $this->integer(11)->notNull()->defaultValue(0));
        $this->addColumn('servers_rating_statistic', 'views', $this->integer(11)->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181009_132111_servers_views cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181009_132111_servers_views cannot be reverted.\n";

        return false;
    }
    */
}
