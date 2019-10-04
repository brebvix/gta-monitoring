<?php

namespace frontend\modules\developer\models;

use Yii;

/**
 * This is the model class for table "questions_tags_relations".
 *
 * @property int $id
 * @property int $tag_id Тег
 * @property int $question_id Вопрос
 *
 * @property Questions $question
 * @property QuestionsTags $tag
 */
class QuestionsTagsRelations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questions_tags_relations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tag_id', 'question_id'], 'required'],
            [['tag_id', 'question_id'], 'integer'],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Questions::className(), 'targetAttribute' => ['question_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestionsTags::className(), 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('questions', 'ID'),
            'tag_id' => Yii::t('questions', 'Тег'),
            'question_id' => Yii::t('questions', 'Вопрос'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Questions::className(), ['id' => 'question_id'])
            ->with('category');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(QuestionsTags::className(), ['id' => 'tag_id']);
    }
}
