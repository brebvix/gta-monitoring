<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "freelance_vacancies_list".
 *
 * @property int $id
 * @property string $title
 * @property string $icon
 *
 * @property FreelanceServices[] $freelanceServices
 * @property FreelanceVacancies[] $freelanceVacancies
 */
class FreelanceVacanciesList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'freelance_vacancies_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 32],
            [['icon'], 'string', 'max' => 34],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('main', 'Заголовок'),
            'icon' => Yii::t('main', 'Иконка'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFreelanceServices()
    {
        return $this->hasMany(FreelanceServices::className(), ['vacancie_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFreelanceVacancies()
    {
        return $this->hasMany(FreelanceVacancies::className(), ['vacancie_id' => 'id']);
    }

    public function getFreelanceVacanciesCount()
    {
        return $this->getFreelanceVacancies()->count();
    }

    public function getBadge()
    {
        switch ($this->id) {
            case 1: return 'red';
            case 2: return 'success';
            case 3: return 'info';
            case 4: return 'warning';
            case 5: return 'light';
            case 6: return 'inverse';
        }
    }

    public function getFreelanceServicesCount()
    {
        return $this->getFreelanceServices()->count();
    }

}
