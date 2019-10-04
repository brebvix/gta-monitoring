<?php

use yii\db\Migration;

/**
 * Class m180829_095918_advertising_banners_fix
 */
class m180829_095918_advertising_banners_fix extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('advertising_banners_buy', 'title', $this->string(16)->defaultValue(''));
        $this->addColumn('advertising_banners_buy', 'link', $this->string(64)->notNull()->defaultValue(''));
        $this->addColumn('advertising_banners_buy', 'image_path', $this->string(128)->notNull()->defaultValue(''));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180829_095918_advertising_banners_fix cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180829_095918_advertising_banners_fix cannot be reverted.\n";

        return false;
    }
    */
}
