<?php

use yii\db\Migration;

/**
 * Class m180830_115724_refactor_comments
 */
class m180830_115724_refactor_comments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-comments-server_id', 'comments');
        $this->dropForeignKey('fk-comments-user_id', 'comments');
        $this->dropColumn('comments', 'user_id');
        $this->dropColumn('comments', 'server_id');
        $this->addColumn('comments', 'main_id', $this->integer(11)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180830_115724_refactor_comments cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180830_115724_refactor_comments cannot be reverted.\n";

        return false;
    }
    */
}
