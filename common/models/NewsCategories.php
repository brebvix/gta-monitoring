<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news_categories".
 *
 * @property int $id
 * @property string $title
 * @property string $title_eng
 * @property int $news_count
 * @property int $news_count_eng
 *
 * @property News[] $news
 */
class NewsCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'title_eng'], 'required'],
            [['news_count', 'news_count_eng'], 'integer'],
            [['title', 'title_eng'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'title' => Yii::t('main', 'Title'),
            'title_eng' => Yii::t('main', 'Title Eng'),
            'news_count' => Yii::t('main', 'News Count'),
            'news_count_eng' => Yii::t('main', 'News Count Eng'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['categorie_id' => 'id']);
    }
}
