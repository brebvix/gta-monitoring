<?php

use yii\db\Migration;

/**
 * Class m180827_075612_activity
 */
class m180827_075612_activity extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('activity', [
            'id' => $this->primaryKey(),
            'main_id' => $this->integer(11)->notNull(),
            'type' => $this->integer(11)->notNull(),
            'data' => $this->text()->notNull(),
            'date' => $this->timestamp()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180827_075612_activity cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180827_075612_activity cannot be reverted.\n";

        return false;
    }
    */
}
