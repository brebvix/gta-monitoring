<?php

use yii\db\Migration;

/**
 * Class m181003_181828_default_rating_fix_2
 */
class m181003_181828_default_rating_fix_2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('servers', 'rating_up', $this->float()->notNull()->defaultValue(1));
        $this->alterColumn('servers', 'rating_down', $this->float()->notNull()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181003_181828_default_rating_fix_2 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181003_181828_default_rating_fix_2 cannot be reverted.\n";

        return false;
    }
    */
}
