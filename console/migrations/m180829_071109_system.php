<?php

use yii\db\Migration;

/**
 * Class m180829_071109_system
 */
class m180829_071109_system extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('system', [
            'id' => $this->primaryKey(),
            'key' => $this->string(32)->notNull()->unique(),
            'value' => $this->string(256),
        ]);

        $this->insert('system', [
            'key' => 'course_rub',
            'value' => 0
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180829_071109_system cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180829_071109_system cannot be reverted.\n";

        return false;
    }
    */
}
