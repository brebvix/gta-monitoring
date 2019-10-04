<?php

use yii\db\Migration;

/**
 * Class m180911_132234_question_platform
 */
class m180911_132234_question_platform extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('questions_categories', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(11)->defaultValue(-1)->comment('ID верхней категории'),
            'title' => $this->string(32)->notNull()->comment('Заголовок'),
            'title_eng' => $this->string(48)->notNull()->comment('Заголовок, англ'),
            'color' => $this->string(32)->defaultValue('light-info')->comment('Цвет'),
            'count' => $this->integer(11)->notNull()->defaultValue(0)->comment('Количество'),
        ]);

        $this->createTable('questions_tags', [
            'id' => $this->primaryKey(),
            'title' => $this->string(24)->notNull()->comment('Заголовок'),
            'title_eng' => $this->string(32)->notNull()->comment('Заголовок, англ'),
            'count' => $this->integer(11)->notNull()->defaultValue(0)->comment('Количество'),
        ]);

        $this->createTable('questions', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull()->comment('Пользователь'),
            'category_id' => $this->integer(11)->notNull()->comment('Категория'),
            'title' => $this->string(128)->notNull()->comment('Заголовок'),
            'title_eng' => $this->string(160)->notNull()->comment('Заголовок, англ'),
            'message' => $this->text()->notNull()->comment('Текст вопроса'),
            'date' => $this->timestamp()->notNull()->comment('Дата'),
            'rating' => $this->integer(11)->notNull()->defaultValue(0)->comment('Рейтинг'),
            'views_count' => $this->integer(11)->notNull()->defaultValue(0)->comment('Просмотры'),
            'hasAnswer' => $this->integer(1)->notNull()->defaultValue(0)->comment('Получен ли ответ'),
            'answers_count' => $this->integer(11)->notNull()->defaultValue(0)->comment('Ответы'),
        ]);

        $this->createTable('questions_tags_relations', [
            'id' => $this->primaryKey(),
            'tag_id' => $this->integer(11)->notNull()->comment('Тег'),
            'question_id' => $this->integer(11)->notNull()->comment('Вопрос'),
        ]);

        $this->createTable('questions_answers', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull()->comment('Пользователь'),
            'question_id' => $this->integer(11)->notNull()->comment('Вопрос'),
            'text' => $this->text()->notNull()->comment('Текст'),
            'rating' => $this->integer(11)->notNull()->defaultValue(0)->comment('Рейтинг'),
            'selected' => $this->integer(1)->notNull()->defaultValue(0)->comment('Выбран как правильный'),
            'date' => $this->timestamp()->notNull()->comment('Дата'),
        ]);

        $this->createTable('questions_comments', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull()->comment('Пользователь'),
            'question_id' => $this->integer(11)->notNull()->comment('Вопрос'),
            'answer_id' => $this->integer(11)->defaultValue(-1)->comment('Ответ'),
            'text' => $this->text()->notNull()->comment('Текст'),
            'date' => $this->timestamp()->notNull()->comment('Дата'),
        ]);

        $this->createTable('questions_rating', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull()->comment('Пользователь'),
            'question_id' => $this->integer(11)->notNull()->comment('Вопрос'),
            'date' => $this->timestamp()->notNull()->comment('Дата'),
        ]);

        $this->createTable('questions_answers_rating', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull()->comment('Пользователь'),
            'answer_id' => $this->integer(11)->notNull()->comment('Ответ'),
            'date' => $this->timestamp()->notNull()->comment('Дата'),
        ]);

        $this->addForeignKey(
            'fk-questions-user_id',
            'questions',
            'user_id',
            'user',
            'id'
        );

        $this->addForeignKey(
            'fk-questions-category_id',
            'questions',
            'category_id',
            'questions_categories',
            'id'
        );

        $this->addForeignKey(
            'fk-questions_tags_relations-tag_id',
            'questions_tags_relations',
            'tag_id',
            'questions_tags',
            'id'
        );

        $this->addForeignKey(
            'fk-questions_tags_relations-question_id',
            'questions_tags_relations',
            'question_id',
            'questions',
            'id'
        );

        $this->addForeignKey(
            'fk-questions_answers-user_id',
            'questions_answers',
            'user_id',
            'user',
            'id'
        );

        $this->addForeignKey(
            'fk-questions_answers-question_id',
            'questions_answers',
            'question_id',
            'questions',
            'id'
        );

        $this->addForeignKey(
            'fk-questions_comments-user_id',
            'questions_comments',
            'user_id',
            'user',
            'id'
        );

        $this->addForeignKey(
            'fk-questions_comments-question_id',
            'questions_comments',
            'question_id',
            'questions',
            'id'
        );

        $this->addForeignKey(
            'fk-questions_rating-question_id',
            'questions_rating',
            'question_id',
            'questions',
            'id'
        );

        $this->addForeignKey(
            'fk-questions_rating-user_id',
            'questions_rating',
            'user_id',
            'user',
            'id'
        );

        $this->addForeignKey(
            'fk-questions_answers_rating-user_id',
            'questions_answers_rating',
            'user_id',
            'user',
            'id'
        );

        $this->addForeignKey(
            'fk-questions_answers_rating-answer_id',
            'questions_answers_rating',
            'answer_id',
            'questions_answers',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180911_132234_question_platform cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180911_132234_question_platform cannot be reverted.\n";

        return false;
    }
    */
}
