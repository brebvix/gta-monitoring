<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "freelance_services".
 *
 * @property int $id
 * @property int $user_id
 * @property int $vacancie_id
 * @property string $title
 * @property string $text
 * @property string $date
 * @property int $minimum_price
 * @property int $price_per_hour
 * @property int $status
 * @property string $portfolio_link
 *
 * @property User $user
 * @property FreelanceVacanciesList $vacancie
 */
class FreelanceServices extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 0;
    const STATUS_NO_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'freelance_services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vacancie_id', 'title', 'text'], 'required'],
            [['user_id', 'vacancie_id', 'minimum_price', 'price_per_hour', 'status'], 'integer'],
            [['text'], 'string'],
            [['date'], 'safe'],
            [['title'], 'string', 'max' => 32],
            [['portfolio_link'], 'string', 'max' => 64],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['vacancie_id'], 'exist', 'skipOnError' => true, 'targetClass' => FreelanceVacanciesList::className(), 'targetAttribute' => ['vacancie_id' => 'id']],
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
            'vacancie_id' => Yii::t('main', 'Категория услуги'),
            'title' => Yii::t('main', 'Заголовок'),
            'text' => Yii::t('main', 'Текст'),
            'date' => Yii::t('main', 'Дата'),
            'minimum_price' => Yii::t('main', 'Минимальная цена'),
            'price_per_hour' => Yii::t('main', 'Стоимость работы в час'),
            'portfolio_link' => Yii::t('main', 'Ссылка на портфолио'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVacancie()
    {
        return $this->hasOne(FreelanceVacanciesList::className(), ['id' => 'vacancie_id']);
    }

    public static function lastCount()
    {
        $lastDay = strtotime(date('Y-m-d H:m:s')) - 86400;

        return self::find()
            ->where(['>=', 'date', date('Y-m-d H:m:s', $lastDay)])
            ->count();
    }
}
