<?php

use yii\db\Migration;

/**
 * Class m180907_070738_news_fix
 */
class m180907_070738_news_fix extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('news', 'language', $this->string(6)->notNull()->defaultValue('ru-RU'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180907_070738_news_fix cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180907_070738_news_fix cannot be reverted.\n";

        return false;
    }
    */
}
