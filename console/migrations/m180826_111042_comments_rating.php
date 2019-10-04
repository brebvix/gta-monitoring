<?php

use yii\db\Migration;

/**
 * Class m180826_111042_comments_rating
 */
class m180826_111042_comments_rating extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comments_rating', [
            'id' => $this->primaryKey(),
            'comment_id' => $this->integer(11)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
            'type' => $this->integer(1)->notNull()->defaultValue(0),
            'date' => $this->timestamp()->notNull()
        ]);

        $this->addColumn('comments', 'rating', $this->integer(11)->defaultValue(0));

        $this->addForeignKey(
            'fk-comments_rating-comment_id',
            'comments_rating',
            'comment_id',
            'comments',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-comments_rating-user_id',
            'comments_rating',
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
        echo "m180826_111042_comments_rating cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180826_111042_comments_rating cannot be reverted.\n";

        return false;
    }
    */
}
