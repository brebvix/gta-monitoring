<?php

use yii\db\Migration;

/**
 * Class m180905_151419_achievements
 */
class m180905_151419_achievements extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('achievements_list', [
            'id' => $this->primaryKey(),
            'title' => $this->string(32)->notNull(),
            'description' => $this->text()->notNull(),
            'icon' => $this->string(32)->notNull(),
            'type_positive' => $this->integer(0)->notNull(),
        ]);

        $this->createTable('achievements_counter', [
            'id' => $this->primaryKey(),
            'achievement_id' => $this->integer(11)->notNull(),
            'main_id' => $this->integer(11)->notNull(),
            'main_type' => $this->integer(2)->notNull(),
            'counter' => $this->integer(11)->notNull()->defaultValue(0)
        ]);

        $this->createTable('achievements', [
            'id' => $this->primaryKey(),
            'main_id' => $this->integer(11)->notNull(),
            'main_type' => $this->integer(2)->notNull(),
            'achievement_id' => $this->integer(11)->notNull(),
        ]);

        $this->addForeignKey(
            'fk-achievements-achievement_id',
            'achievements',
            'achievement_id',
            'achievements_list',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-achievements_counter-achievement_id',
            'achievements_counter',
            'achievement_id',
            'achievements_list',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180905_151419_achievements cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180905_151419_achievements cannot be reverted.\n";

        return false;
    }
    */
}
