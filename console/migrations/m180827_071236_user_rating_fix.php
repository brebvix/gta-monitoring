<?php

use yii\db\Migration;

/**
 * Class m180827_071236_user_rating_fix
 */
class m180827_071236_user_rating_fix extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('user', 'rating_up', $this->float()->notNull()->defaultValue(0));
        $this->alterColumn('user', 'rating_down', $this->float()->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180827_071236_user_rating_fix cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180827_071236_user_rating_fix cannot be reverted.\n";

        return false;
    }
    */
}
