<?php

use yii\db\Migration;

/**
 * Class m180827_122942_user_notifications
 */
class m180827_122942_user_notifications extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_notifications', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'type' => $this->integer(11)->notNull(),
            'data' => $this->text()->notNull(),
            'seen' => $this->integer(1)->notNull()->defaultValue(0),
            'date' => $this->timestamp()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-user_notifications-user_id',
            'user_notifications',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180827_122942_user_notifications cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180827_122942_user_notifications cannot be reverted.\n";

        return false;
    }
    */
}
