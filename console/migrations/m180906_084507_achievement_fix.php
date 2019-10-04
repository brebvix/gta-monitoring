<?php

use yii\db\Migration;

/**
 * Class m180906_084507_achievement_fix
 */
class m180906_084507_achievement_fix extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('achievements', 'date', $this->timestamp()->notNull());
        $this->addColumn('achievements_counter', 'date', $this->timestamp()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180906_084507_achievement_fix cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180906_084507_achievement_fix cannot be reverted.\n";

        return false;
    }
    */
}
