<?php

use yii\db\Migration;

/**
 * Class m180830_112810_news
 */
class m180830_112810_news extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'title' => $this->string(128)->notNull(),
            'short_text' => $this->text()->notNull(),
            'full_text' => $this->text()->notNull(),
            'date' => $this->timestamp()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180830_112810_news cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180830_112810_news cannot be reverted.\n";

        return false;
    }
    */
}
