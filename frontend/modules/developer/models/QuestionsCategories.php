<?php

namespace frontend\modules\developer\models;

use Yii;

/**
 * This is the model class for table "questions_categories".
 *
 * @property int $id
 * @property int $parent_id ID верхней категории
 * @property string $title Заголовок
 * @property string $title_eng Заголовок, англ
 * @property string $color Цвет
 * @property int $count Количество
 *
 * @property Questions[] $questions
 */
class QuestionsCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questions_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'count'], 'integer'],
            [['title', 'title_eng'], 'required'],
            [['title', 'color'], 'string', 'max' => 32],
            [['title_eng'], 'string', 'max' => 48],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('questions', 'ID'),
            'parent_id' => Yii::t('questions', 'ID верхней категории'),
            'title' => Yii::t('questions', 'Заголовок'),
            'title_eng' => Yii::t('questions', 'Заголовок, англ'),
            'color' => Yii::t('questions', 'Цвет'),
            'count' => Yii::t('questions', 'Количество'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Questions::className(), ['category_id' => 'id']);
    }

    public function getChild()
    {
        return $this->hasMany(QuestionsCategories::className(), ['parent_id' => 'id']);
    }

    public function getParent()
    {
        return $this->hasOne(QuestionsCategories::className(), ['id' => 'parent_id']);
    }
}
