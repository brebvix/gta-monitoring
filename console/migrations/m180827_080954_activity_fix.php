<?php

use yii\db\Migration;

/**
 * Class m180827_080954_activity_fix
 */
class m180827_080954_activity_fix extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('activity', 'main_type', $this->integer(1)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180827_080954_activity_fix cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180827_080954_activity_fix cannot be reverted.\n";

        return false;
    }
    */
}
