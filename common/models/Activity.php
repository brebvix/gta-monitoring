<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "activity".
 *
 * @property int $id
 * @property int $main_id
 * @property int $main_type
 * @property int $type
 * @property string $data
 * @property string $date
 */
class Activity extends \yii\db\ActiveRecord
{
    const MAIN_TYPE_USER = 0;
    const MAIN_TYPE_SERVER = 1;

    const TYPE_NEW_USER = 0;
    const TYPE_NEW_COMMENT = 1;
    const TYPE_COMMENT_RATING_CHANGE = 2;
    const TYPE_SERVER_RATING_CHANGE = 3;
    const TYPE_NEW_FREELANCE_VACANCY = 4;
    const TYPE_NEW_FREELANCE_SERVICE = 5;
    const TYPE_NEW_USER_ACHIEVEMENT = 6;
    const TYPE_NEW_SERVER_ACHIEVEMENT = 7;
    const TYPE_NEW_QUESTION = 8;
    const TYPE_NEW_QUESTION_ANSWER = 9;
    const TYPE_NEW_QUESTION_COMMENT = 10;
    const TYPE_NEW_QUESTION_ANSWER_COMMENT = 11;
    const TYPE_QUESTION_RATING_CHANGE = 12;
    const TYPE_QUESTION_ANSWER_RATING_CHANGE = 13;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['main_id', 'main_type', 'type', 'data'], 'required'],
            [['main_id', 'main_type', 'type'], 'integer'],
            [['data'], 'string'],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'main_id' => Yii::t('app', 'Main ID'),
            'type' => Yii::t('app', 'Type'),
            'data' => Yii::t('app', 'Data'),
            'date' => Yii::t('app', 'Date'),
        ];
    }

    public function getColorClass()
    {
        switch ($this->type) {
            case self::TYPE_NEW_USER: return 'info';
            case self::TYPE_NEW_COMMENT: return 'info';
        }
    }

    public function getIcon()
    {
        switch ($this->type) {
            case self::TYPE_NEW_USER: return '<i class="fa fa-user-plus"></i>';
            case self::TYPE_NEW_COMMENT: return '<i class="fa fa-commenting"></i>';
        }
    }
}
