<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "advertising_links".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $background
 * @property string $text_color
 * @property int $days
 * @property string $date
 * @property int $status
 * @property int $link_id
 *
 * @property User $user
 * @property Links $link
 */
class AdvertisingLinks extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 0;
    const STATUS_NO_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'advertising_links';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'background', 'text_color', 'days', 'link'], 'required'],
            [['user_id', 'days', 'status'], 'integer'],
            [['date'], 'safe'],
            [['title', 'background', 'text_color'], 'string', 'max' => 32],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('main', 'Пользователь'),
            'title' => Yii::t('main', 'Текст'),
            'link' => Yii::t('main', 'Ссылка'),
            'background' => Yii::t('main', 'Цвет фона'),
            'text_color' => Yii::t('main', 'Цвет текста'),
            'days' => Yii::t('main', 'Дни'),
            'date' => Yii::t('main', 'Дата'),
            'status' => Yii::t('main', 'Статус'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getLink()
    {
        return $this->hasOne(Links::className(), ['id' => 'link_id']);
    }
}
