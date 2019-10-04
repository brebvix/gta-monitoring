<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ServersStatistic;

/**
 * ServersStatisticSearch represents the model behind the search form of `common\models\ServersStatistic`.
 */
class ServersStatisticSearch extends ServersStatistic
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'server_id', 'players'], 'integer'],
            [['date'], 'safe'],
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
    public function search($params)
    {
        $query = ServersStatistic::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'server_id' => $this->server_id,
            'date' => $this->date,
            'players' => $this->players,
        ]);

        return $dataProvider;
    }
}
