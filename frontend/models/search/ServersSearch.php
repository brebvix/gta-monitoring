<?php

namespace frontend\models\search;

use \Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Servers;

/**
 * ServersSearch represents the model behind the search form of `common\models\Servers`.
 */
class ServersSearch extends Servers
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'game_id', 'rating'], 'integer'],
            [['ip', 'port', 'title',], 'safe'],
            [['rating'], 'number'],
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
        $query = Servers::find()
        ->with('achievements');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'vip' => SORT_DESC,
                    'rating' => SORT_DESC,
                    'players' => SORT_DESC,
                ]
            ],
            'pagination' => [
                'pageSize' => 50,
            ],
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
            'game_id' => $this->game_id,
            'players' => $this->players,
            'maxplayers' => $this->maxplayers,
            'status' => Servers::STATUS_ACTIVE
        ]);
        return $dataProvider;
    }
}
