<?php

use yii\db\Migration;

/**
 * Class m180905_163430_achievement_fix
 */
class m180905_163430_achievement_fix extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('achievements_list', 'icon', $this->string(64)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180905_163430_achievement_fix cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180905_163430_achievement_fix cannot be reverted.\n";

        return false;
    }
    */
}
