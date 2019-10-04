<?php

use yii\db\Migration;

/**
 * Class m180912_091941_question_table_fix
 */
class m180912_091941_question_table_fix extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('questions', 'short_message', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180912_091941_question_table_fix cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180912_091941_question_table_fix cannot be reverted.\n";

        return false;
    }
    */
}
