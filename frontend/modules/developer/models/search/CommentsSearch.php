<?php

namespace frontend\modules\developer\models\search;

use frontend\modules\developer\models\Questions;
use frontend\modules\developer\models\QuestionsAnswers;
use frontend\modules\developer\models\QuestionsComments;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * News represents the model behind the search form of `common\models\News`.
 */
class CommentsSearch extends QuestionsComments
{
    public $question_id;
    public $answer_id;

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search()
    {
        $query = QuestionsComments::find()
            ->where(['question_id' => $this->question_id, 'answer_id' => $this->answer_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        return $dataProvider;
    }
}
