<?php

use yii\db\Migration;

/**
 * Class m181003_181108_default_rating_fix
 */
class m181003_181108_default_rating_fix extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('servers', 'rating', $this->float()->notNull()->defaultValue(2.54));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181003_181108_default_rating_fix cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181003_181108_default_rating_fix cannot be reverted.\n";

        return false;
    }
    */
}
