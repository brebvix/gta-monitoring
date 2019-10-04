<?php

use yii\db\Migration;

/**
 * Class m180823_121651_user_contacts
 */
class m180823_121651_user_contacts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'skype', $this->string(32)->defaultValue(''));
        $this->addColumn('user', 'vk', $this->string(32)->defaultValue(''));
        $this->addColumn('user', 'telegram', $this->string(32)->defaultValue(''));
        $this->addColumn('user', 'about_me', $this->string(160)->defaultValue(''));
        $this->addColumn('user', 'avatar', $this->integer(1)->notNull()->defaultValue('0'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180823_121651_user_contacts cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180823_121651_user_contacts cannot be reverted.\n";

        return false;
    }
    */
}
