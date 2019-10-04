<?php
namespace frontend\models\form\freelance;

use common\models\FreelanceVacanciesList;
use Yii;
use common\models\FreelanceVacancies;
use yii\helpers\HtmlPurifier;
use common\models\Activity;

class VacancieAddForm extends FreelanceVacancies
{
    public $reCaptcha;

    public function rules()
    {
        return [
            [['payment', 'title', 'text', 'work_time', 'vacancie_id'], 'required'],
            ['payment', 'integer', 'min' => 0],
            ['title', 'string', 'min' => 6, 'max' => 32],
            ['text', 'string', 'min' => 24, 'max' => 2048],
            ['work_time', 'integer'],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className()],
        ];
    }

    public function addVacancie()
    {
        if (!$this->validate() || $this->payment < 0) {
            return false;
        }

        $this->user_id = Yii::$app->user->id;
        $this->title = HtmlPurifier::process($this->title);
        $this->text = HtmlPurifier::process($this->text);

        if (!$this->save()) {
            return false;
        }

        $activity = new Activity();
        $activity->type = Activity::TYPE_NEW_FREELANCE_VACANCY;
        $activity->main_id = $this->user_id;
        $activity->main_type = Activity::MAIN_TYPE_USER;
        $activity->data = json_encode([
            'username' => Yii::$app->user->identity->username,
            'vacancy_category' => $this->vacancie->title,
            'vacancie_id' => $this->id
        ]);

        return $activity->save();
    }
}