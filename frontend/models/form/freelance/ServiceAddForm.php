<?php
namespace frontend\models\form\freelance;

use Yii;
use common\models\FreelanceServices;
use yii\helpers\HtmlPurifier;
use common\models\Activity;
use common\models\FreelanceVacanciesList;

class ServiceAddForm extends FreelanceServices
{
    public $minimum_price = 0;
    public $price_per_hour = 0;
    public $portfolio_link = '';
    public $reCaptcha;

    public function rules()
    {
        return [
            [['vacancie_id', 'title', 'text'], 'required'],
            [['user_id', 'vacancie_id', 'minimum_price', 'price_per_hour'], 'integer'],
            [['text'], 'string'],
            ['title', 'string', 'min' => 6, 'max' => 32],
            ['text', 'string', 'min' => 24, 'max' => 2048],
            [['portfolio_link'], 'string', 'max' => 64],
            [['vacancie_id'], 'exist', 'skipOnError' => true, 'targetClass' => FreelanceVacanciesList::className(), 'targetAttribute' => ['vacancie_id' => 'id']],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className()],
        ];
    }

    public function addService()
    {
        if (!$this->validate() || $this->minimum_price < 0 || $this->price_per_hour < 0) {
            return false;
        }

        $this->user_id = Yii::$app->user->id;
        $this->title = HtmlPurifier::process($this->title);
        $this->text = HtmlPurifier::process($this->text);
        $this->portfolio_link = HtmlPurifier::process($this->portfolio_link);

        if (!$this->save()) {
            return false;
        }

        $activity = new Activity();
        $activity->type = Activity::TYPE_NEW_FREELANCE_SERVICE;
        $activity->main_id = $this->user_id;
        $activity->main_type = Activity::MAIN_TYPE_USER;
        $activity->data = json_encode([
            'username' => Yii::$app->user->identity->username,
            'service_category' => $this->vacancie->title,
            'service_id' => $this->id
        ]);

        return $activity->save();
    }
}