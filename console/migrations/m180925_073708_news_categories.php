<?php

use yii\db\Migration;

/**
 * Class m180925_073708_news_categories
 */
class m180925_073708_news_categories extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('news_categories', [
            'id' => $this->primaryKey(),
            'title' => $this->string(32)->notNull(),
            'title_eng' => $this->string(32)->notNull(),
            'news_count' => $this->integer(11)->notNull()->defaultValue(0),
            'news_count_eng' => $this->integer(11)->notNull()->defaultValue(0),
        ]);

        $this->addColumn('news', 'categorie_id', $this->integer(11)->notNull()->defaultValue(1));
        $this->addColumn('news', 'views_count', $this->integer(11)->notNull()->defaultValue(0));

        $this->insert('news_categories', [
            'id' => 1,
            'title' => 'Новости сайта',
            'title_eng' => 'site'
        ]);

        $this->insert('news_categories', [
            'id' => 2,
            'title' => 'API',
            'title_eng' => 'api',
        ]);

        $this->addForeignKey(
            'fk-news-categorie_id',
            'news',
            'categorie_id',
            'news_categories',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180925_073708_news_categories cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180925_073708_news_categories cannot be reverted.\n";

        return false;
    }
    */
}
