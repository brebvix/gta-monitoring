<?php
namespace frontend\models\form;

use common\models\Comments;
use yii\helpers\HtmlPurifier;
use Yii;
use common\models\User;

class AddCommentForm extends Comments
{
    public $captcha;

    public function rules()
    {

        $data = [
            ['captcha', 'captcha'],
        ];
        return array_merge(parent::rules(), $data);
    }

    public function saveComment()
    {
        $this->text = HtmlPurifier::process($this->text);
        $this->author_id = Yii::$app->user->id;
        $this->date = date('Y-m-d H:i:s');

        return $this->save();
    }
}