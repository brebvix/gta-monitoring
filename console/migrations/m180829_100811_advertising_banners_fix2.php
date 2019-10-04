<?php

use yii\db\Migration;

/**
 * Class m180829_100811_advertising_banners_fix2
 */
class m180829_100811_advertising_banners_fix2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('advertising_banners_buy', 'banner_id', $this->integer(11)->notNull());

        $this->addForeignKey(
            'fk-advertising_banners_buy-banner_id',
            'advertising_banners_buy',
            'banner_id',
            'advertising_banners',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180829_100811_advertising_banners_fix2 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180829_100811_advertising_banners_fix2 cannot be reverted.\n";

        return false;
    }
    */
}
