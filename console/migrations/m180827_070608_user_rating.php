<?php

use yii\db\Migration;

/**
 * Class m180827_070608_user_rating
 */
class m180827_070608_user_rating extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'rating', $this->float()->notNull()->defaultValue(0));
        $this->addColumn('user', 'rating_up', $this->integer(11)->notNull()->defaultValue(0));
        $this->addColumn('user', 'rating_down', $this->integer(11)->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180827_070608_user_rating cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180827_070608_user_rating cannot be reverted.\n";

        return false;
    }
    */
}
