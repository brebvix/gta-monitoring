<?php

use yii\db\Migration;

/**
 * Class m180828_122111_freelance_title_max_size
 */
class m180828_122111_freelance_title_max_size extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('freelance_services', 'title', $this->string(64)->notNull());
        $this->alterColumn('freelance_vacancies', 'title', $this->string(64)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180828_122111_freelance_title_max_size cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180828_122111_freelance_title_max_size cannot be reverted.\n";

        return false;
    }
    */
}
