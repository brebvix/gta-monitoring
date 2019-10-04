<?php

use yii\db\Migration;

/**
 * Class m180829_092201_advertising_banners
 */
class m180829_092201_advertising_banners extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('advertising_banners', [
            'id' => $this->primaryKey(),
            'size' => $this->string(10)->notNull()->comment('Размер баннера'),
            'title' => $this->integer(1)->notNull()->defaultValue(0)->comment('Есть ли заголовок'),
            'status' => $this->integer(1)->notNull()->defaultValue(0),
            'buy_id' => $this->integer(11)->defaultValue(-1),
            'price' => $this->integer(11)->defaultValue(0),
        ]);

        $this->createTable('advertising_banners_buy', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'date' => $this->timestamp()->notNull(),
            'days' => $this->integer(4)->notNull(),
            'status' => $this->integer(1)->notNull()->defaultValue(0),
        ]);

        $this->addForeignKey(
            'fk-advertising_banners_buy-user_id',
            'advertising_banners_buy',
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
        echo "m180829_092201_advertising_banners cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180829_092201_advertising_banners cannot be reverted.\n";

        return false;
    }
    */
}
