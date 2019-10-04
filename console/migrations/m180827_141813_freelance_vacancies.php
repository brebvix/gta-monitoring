<?php

use yii\db\Migration;

/**
 * Class m180827_141813_freelance_vacancies
 */
class m180827_141813_freelance_vacancies extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('freelance_vacancies', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'server_id' => $this->integer(11)->defaultValue(-1),
            'vacancie_id' => $this->integer(11)->notNull(),
            'text' => $this->text()->notNull(),
            'payment' => $this->integer(11)->notNull()->defaultValue(0),
            'work_time' => $this->integer(1)->notNull()->defaultValue(0)->comment('Разовая / постоянная работа'),
            'title' => $this->string(32)->notNull(),
            'date' => $this->timestamp()->notNull(),
            'status' => $this->integer(1)->notNull()->defaultValue(0),
         ]);

        $this->addForeignKey(
            'fk-freelance_vacancies-user_id',
            'freelance_vacancies',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        /*$this->addForeignKey(
            'fk-freelance_vacancies-server_id',
            'freelance_vacancies',
            'server_id',
            'servers',
            'id',
            'CASCADE'
        );*/

        $this->addForeignKey(
            'fk-freelance_vacancies-vacancie_id',
            'freelance_vacancies',
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
        echo "m180827_141813_freelance_vacancies cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180827_141813_freelance_vacancies cannot be reverted.\n";

        return false;
    }
    */
}
