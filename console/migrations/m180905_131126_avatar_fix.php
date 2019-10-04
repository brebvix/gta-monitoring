<?php

use yii\db\Migration;

/**
 * Class m180905_131126_avatar_fix
 */
class m180905_131126_avatar_fix extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('user', 'avatar');
        $this->addColumn('user','avatar', $this->string(48)->defaultValue(''));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180905_131126_avatar_fix cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180905_131126_avatar_fix cannot be reverted.\n";

        return false;
    }
    */
}
