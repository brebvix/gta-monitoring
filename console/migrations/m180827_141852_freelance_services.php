<?php

use yii\db\Migration;

/**
 * Class m180827_141852_freelance_services
 */
class m180827_141852_freelance_services extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('freelance_services', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'vacancie_id' => $this->integer(11)->notNull(),
            'title' => $this->string(32)->notNull(),
            'text' => $this->text()->notNull(),
            'date' => $this->timestamp()->notNull(),
            'minimum_price' => $this->integer()->notNull()->defaultValue(0),
            'price_per_hour' => $this->integer()->notNull()->defaultValue(0),
            'portfolio_link' => $this->string(64)->defaultValue(''),
        ]);

        $this->addForeignKey(
            'fk-freelance_services-user_id',
            'freelance_services',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-freelance_services-vacancie_id',
            'freelance_services',
            'vacancie_id',
            'freelance_vacancies_list',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180827_141852_freelance_services cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180827_141852_freelance_services cannot be reverted.\n";

        return false;
    }
    */
}
