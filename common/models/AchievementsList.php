<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "achievements_list".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $icon
 * @property int $type_positive
 *
 * @property Achievements[] $achievements
 * @property AchievementsCounter[] $achievementsCounters
 */
class AchievementsList extends \yii\db\ActiveRecord
{
    const TYPE_POSITIVE_NO = 0;
    const TYPE_POSITIVE_YES = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'achievements_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'icon', 'type_positive'], 'required'],
            [['description'], 'string'],
            [['type_positive'], 'integer'],
            [['title', 'icon'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'icon' => Yii::t('app', 'Icon'),
            'type_positive' => Yii::t('app', 'Type Positive'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAchievements()
    {
        return $this->hasMany(Achievements::className(), ['achievement_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAchievementsCounters()
    {
        return $this->hasMany(AchievementsCounter::className(), ['achievement_id' => 'id']);
    }
}
