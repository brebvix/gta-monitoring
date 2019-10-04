<?php

use yii\db\Migration;

/**
 * Class m180902_085518_user_language
 */
class m180902_085518_user_language extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'language', $this->string(5)->defaultValue('ru'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180902_085518_user_language cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180902_085518_user_language cannot be reverted.\n";

        return false;
    }
    */
}
