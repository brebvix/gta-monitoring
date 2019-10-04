<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "freelance_vacancies".
 *
 * @property int $id
 * @property int $user_id
 * @property int $server_id
 * @property int $vacancie_id
 * @property string $text
 * @property int $payment
 * @property int $work_time Разовая / постоянная работа
 * @property string $title
 * @property string $date
 * @property int $status
 *
 * @property Servers $server
 * @property User $user
 * @property FreelanceVacanciesList $vacancie
 */
class FreelanceVacancies extends \yii\db\ActiveRecord
{
    const WORK_TEMP = 0;
    const WORK_ALL = 1;

    const STATUS_ACTIVE = 0;
    const STATUS_NO_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'freelance_vacancies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'title'], 'required'],
            [['user_id', 'server_id', 'vacancie_id', 'payment', 'work_time', 'status'], 'integer'],
            [['text'], 'string'],
            [['date', 'vacancie_id'], 'safe'],
            [['title'], 'string', 'max' => 32],
            //[['server_id'], 'exist', 'skipOnError' => true, 'targetClass' => Servers::className(), 'targetAttribute' => ['server_id' => 'id']],
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
            'server_id' => Yii::t('main', 'Сервер'),
            'vacancie_id' => Yii::t('main', 'Вакансия'),
            'text' => Yii::t('main', 'Описание'),
            'payment' => Yii::t('main', 'Оплата, руб.'),
            'work_time' => Yii::t('main', 'Разовая / постоянная работа'),
            'title' => Yii::t('main', 'Заголовок'),
            'date' => Yii::t('main', 'Дата'),
            'status' => Yii::t('main', 'Статус'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServer()
    {
        return $this->hasOne(Servers::className(), ['id' => 'server_id']);
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
