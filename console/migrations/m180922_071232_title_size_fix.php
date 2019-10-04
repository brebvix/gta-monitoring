<?php

use yii\db\Migration;

/**
 * Class m180922_071232_title_size_fix
 */
class m180922_071232_title_size_fix extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('servers', 'title', $this->string(148));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180922_071232_title_size_fix cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180922_071232_title_size_fix cannot be reverted.\n";

        return false;
    }
    */
}
