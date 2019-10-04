<?php

use yii\db\Migration;

/**
 * Class m180904_155424_links
 */
class m180904_155424_links extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('links', [
            'id' => $this->primaryKey(),
            'identifier' => $this->string(64)->notNull()->unique(),
            'link' => $this->string(128)->notNull(),
            'clicks' => $this->integer(11)->notNull()->defaultValue(0),
            'date' => $this->timestamp()->notNull(),
        ]);

        $this->dropColumn('advertising_banners_buy', 'link');
        $this->dropColumn('advertising_links', 'link');

        $this->addColumn('advertising_banners_buy', 'link_id', $this->integer(11)->notNull());
        $this->addColumn('advertising_links', 'link_id', $this->integer(11)->notNull());

        $this->addForeignKey(
            'fk-advertising_banners_buy-link_id',
            'advertising_banners_buy',
            'link_id',
            'links',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-advertising_links-link_id',
            'advertising_links',
            'link_id',
            'links',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180904_155424_links cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180904_155424_links cannot be reverted.\n";

        return false;
    }
    */
}
