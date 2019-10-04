<?php

use yii\db\Migration;

/**
 * Class m180905_132623_avatar_fix2
 */
class m180905_132623_avatar_fix2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('user', 'avatar', 'avatar_hash');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180905_132623_avatar_fix2 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180905_132623_avatar_fix2 cannot be reverted.\n";

        return false;
    }
    */
}
