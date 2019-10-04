<?php

use yii\db\Migration;

/**
 * Class m180829_112637_advertising_links
 */
class m180829_112637_advertising_links extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('advertising_links', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'title' => $this->string(32)->notNull(),
            'link' => $this->string(64)->notNull(),
            'background' => $this->string(32)->notNull(),
            'text_color' => $this->string(32)->notNull(),
            'days' => $this->integer(3)->notNull(),
            'date' => $this->timestamp()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-advertising_links-user_id',
            'advertising_links',
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
        echo "m180829_112637_advertising_links cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180829_112637_advertising_links cannot be reverted.\n";

        return false;
    }
    */
}
