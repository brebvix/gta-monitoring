<?php

namespace frontend\modules\developer\models\search;

use frontend\modules\developer\models\Questions;
use frontend\modules\developer\models\QuestionsAnswers;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * News represents the model behind the search form of `common\models\News`.
 */
class AnswersSearch extends QuestionsAnswers
{
    public $question_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'date'], 'safe'],
        ];
    }

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
        $query = QuestionsAnswers::find()
            ->with('comments')
            ->where(['question_id' => $this->question_id]);

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
