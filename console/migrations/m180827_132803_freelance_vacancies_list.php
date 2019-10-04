<?php

use yii\db\Migration;

/**
 * Class m180827_142803_vacancies
 */
class m180827_132803_freelance_vacancies_list extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('freelance_vacancies_list', [
            'id' => $this->primaryKey(),
            'title' => $this->string(32)->notNull(),
            'icon' => $this->string(34)->notNull()->defaultValue('<i class="fa fa-globe"></i>')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180827_142803_vacancies cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180827_142803_vacancies cannot be reverted.\n";

        return false;
    }
    */
}
