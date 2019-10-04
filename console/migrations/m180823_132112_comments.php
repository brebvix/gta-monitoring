<?php

use yii\db\Migration;

/**
 * Class m180823_132112_comments
 */
class m180823_132112_comments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comments', [
            'id' => $this->primaryKey(),
            'server_id' => $this->integer(11)->defaultValue(0),
            'user_id' => $this->integer(11)->defaultValue(0),
            'author_id' => $this->integer(11)->notNull(),
            'text' => $this->text()->notNull(),
            'date' => $this->timestamp()->notNull(),
            'type' => $this->integer(1)->notNull(),
            'type_positive' => $this->integer(1)->notNull()->defaultValue(0),
        ]);

        $this->addForeignKey(
            'fk-comments-server_id',
            'comments',
            'server_id',
            'servers',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-comments-user_id',
            'comments',
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
        echo "m180823_132112_comments cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180823_132112_comments cannot be reverted.\n";

        return false;
    }
    */
}
