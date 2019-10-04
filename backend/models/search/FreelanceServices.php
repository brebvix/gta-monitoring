<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\FreelanceServices as FreelanceServicesModel;

/**
 * FreelanceServices represents the model behind the search form of `common\models\FreelanceServices`.
 */
class FreelanceServices extends FreelanceServicesModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'vacancie_id', 'minimum_price', 'price_per_hour'], 'integer'],
            [['title', 'text', 'date', 'portfolio_link'], 'safe'],
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
        $query = FreelanceServicesModel::find();

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
            'user_id' => $this->user_id,
            'vacancie_id' => $this->vacancie_id,
            'date' => $this->date,
            'minimum_price' => $this->minimum_price,
            'price_per_hour' => $this->price_per_hour,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'portfolio_link', $this->portfolio_link]);

        return $dataProvider;
    }
}
