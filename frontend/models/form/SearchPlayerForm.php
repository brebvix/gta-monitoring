<?php
namespace frontend\models\form;

use common\models\Players;
use yii\helpers\HtmlPurifier;
use Yii;

class SearchPlayerForm extends Players
{
    public $captcha;

    public function rules()
    {
        return [
            ['nickname', 'required'],
            ['nickname', 'string', 'max' => 32],
        ];
    }
}