<?php

use yii\db\Migration;

/**
 * Class m180925_082021_news_title_eng
 */
class m180925_082021_news_title_eng extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('news', 'title_eng', $this->string(64)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180925_082021_news_title_eng cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180925_082021_news_title_eng cannot be reverted.\n";

        return false;
    }
    */
}
