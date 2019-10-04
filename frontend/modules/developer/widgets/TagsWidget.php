<?php
namespace frontend\modules\developer\widgets;

use frontend\modules\developer\models\QuestionsCategories;
use frontend\modules\developer\models\QuestionsTags;

class TagsWidget extends \yii\bootstrap\Widget
{
    public function run()
    {
        $data = QuestionsTags::find()
        ->all();

        return $this->render('tags', [
            'tagsList' => $data,
        ]);
    }
}