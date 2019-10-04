<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "achievements_counter".
 *
 * @property int $id
 * @property int $achievement_id
 * @property int $main_id
 * @property int $main_type
 * @property int $counter
 *
 * @property AchievementsList $achievement
 */
class AchievementsCounter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'achievements_counter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['achievement_id', 'main_id', 'main_type'], 'required'],
            [['achievement_id', 'main_id', 'main_type', 'counter'], 'integer'],
            [['achievement_id'], 'exist', 'skipOnError' => true, 'targetClass' => AchievementsList::className(), 'targetAttribute' => ['achievement_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'achievement_id' => Yii::t('app', 'Achievement ID'),
            'main_id' => Yii::t('app', 'Main ID'),
            'main_type' => Yii::t('app', 'Main Type'),
            'counter' => Yii::t('app', 'Counter'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAchievement()
    {
        return $this->hasOne(AchievementsList::className(), ['id' => 'achievement_id']);
    }

    public function createAchievement()
    {
        $achievement = new Achievements();
        $achievement->achievement_id = $this->achievement_id;
        $achievement->main_id = $this->main_id;
        $achievement->main_type = $this->main_type;

        return $achievement->save();
    }

    public function beforeSave($insert)
    {
        switch ($this->achievement_id) {
            case 1:
                if ($this->counter >= 10) {
                    return $this->createAchievement();
                }
                break;
            case 2:
                if ($this->counter >= 10) {
                    return $this->createAchievement();
                }
                break;
            case 3:
                if ($this->counter >= 100) {
                    return $this->createAchievement();
                }
                break;
            case 8:
                if ($this->counter >= 5) {
                    return $this->createAchievement();
                }
                break;
            case 9:
                if ($this->counter >= 5) {
                    return $this->createAchievement();
                }
                break;
            case 10:
                if ($this->counter >= 20) {
                    return $this->createAchievement();
                }
                break;
            case 11:
                if ($this->counter >= 20) {
                    return $this->createAchievement();
                }
                break;
        }

        return parent::beforeSave($insert);
    }
}
