<?php
namespace frontend\modules\developer\widgets;

use frontend\modules\developer\models\QuestionsCategories;

class CategoriesListWidget extends \yii\bootstrap\Widget
{
    public $active;

    public function run()
    {
        $data = QuestionsCategories::find()
            ->where(['parent_id' => -1])
            ->with('child')
            ->all();

        return $this->render('categories', [
            'categoriesList' => $data,
        ]);
    }
}