<?php

use yii\db\Migration;

/**
 * Class m180826_122535_dialog
 */
class m180826_122535_dialogs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('dialogs', [
            'id' => $this->primaryKey(),
            'user_one' => $this->integer(11)->notNull(),
            'user_two' => $this->integer(11)->notNull(),
            'date' => $this->timestamp()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-dialogs-user_one',
            'dialogs',
            'user_one',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-dialogs-user_two',
            'dialogs',
            'user_two',
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
        echo "m180826_122535_dialog cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180826_122535_dialog cannot be reverted.\n";

        return false;
    }
    */
}
