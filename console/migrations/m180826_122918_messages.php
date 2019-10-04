<?php

use yii\db\Migration;

/**
 * Class m180826_122918_messages
 */
class m180826_122918_messages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('messages', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'dialog_id' => $this->integer()->notNull(),
            'message' => $this->text()->notNull(),
            'date' => $this->timestamp()->notNull(),
            'seen' => $this->integer(1)->defaultValue(0),
        ]);

        $this->addForeignKey(
            'fk-messages-user_id',
            'messages',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-messages-dialog_id',
            'messages',
            'dialog_id',
            'dialogs',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180826_122918_messages cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180826_122918_messages cannot be reverted.\n";

        return false;
    }
    */
}
