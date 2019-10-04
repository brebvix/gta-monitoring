<?php

use yii\db\Migration;

/**
 * Class m180829_113432_advertising_links_fix
 */
class m180829_113432_advertising_links_fix extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('advertising_links', 'status', $this->integer(1)->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180829_113432_advertising_links_fix cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180829_113432_advertising_links_fix cannot be reverted.\n";

        return false;
    }
    */
}
