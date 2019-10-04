<?php

namespace frontend\modules\developer\models;

use Yii;
/**
 * This is the model class for table "questions_tags".
 *
 * @property int $id
 * @property string $title Заголовок
 * @property string $title_eng Заголовок, англ
 * @property int $count Количество
 *
 * @property QuestionsTagsRelations[] $questionsTagsRelations
 */
class QuestionsTags extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questions_tags';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'title_eng'], 'required'],
            [['count'], 'integer'],
            [['title'], 'string', 'max' => 24],
            [['title_eng'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('questions', 'ID'),
            'title' => Yii::t('questions', 'Заголовок'),
            'title_eng' => Yii::t('questions', 'Заголовок, англ'),
            'count' => Yii::t('questions', 'Количество'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelations()
    {
        return $this->hasMany(QuestionsTagsRelations::className(), ['tag_id' => 'id'])
            ->with('question');
    }
}
