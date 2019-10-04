<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Players;
use yii\db\Query;

/**
 * PlayersSearch represents the model behind the search form of `common\models\Players`.
 */
class PlayersSearch extends Players
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
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
     * @return ActiveDataProvider
     */
    public function search()
    {
        $queryResult = Players::find()
            ->orderBy(['id' => SORT_DESC])
            ->limit(20);

        $dataProvider = new ActiveDataProvider([
            'query' => $queryResult,
            //'totalCount' => $queryResult->count(),
            'totalCount' => 20,
            'sort' => false,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $dataProvider;
    }
}
