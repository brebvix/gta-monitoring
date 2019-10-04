<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property int $main_id
 * @property int $author_id
 * @property string $text
 * @property string $date
 * @property int $type
 * @property int $type_positive
 * @property int $rating
 *
 * @property Servers $server
 * @property User $user
 */
class Comments extends \yii\db\ActiveRecord
{
    const TYPE_SERVER = 0;
    const TYPE_USER = 1;
    const TYPE_NEWS = 2;

    const POSITIVE = 0;
    const NEGATIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['main_id', 'author_id', 'type', 'type_positive'], 'integer'],
            [['author_id', 'main_id', 'text', 'date', 'type'], 'required'],
            [['text'], 'string'],
            [['date', 'type', 'type_positive', 'rating'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'main' => Yii::t('main', 'Основной ID'),
            'author_id' => Yii::t('main', 'Автор'),
            'text' => Yii::t('main', 'Текст'),
            'date' => Yii::t('main', 'Дата'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    public function getCommentsRating()
    {
        return $this->hasMany(CommentsRating::className(), ['comment_id' => 'id']);
    }

    public static function getCountById($id, $type)
    {
        return self::find()
            ->where(['main_id' => $id, 'type' => $type])
            ->count();
    }
}
