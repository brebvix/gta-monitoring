<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Servers;
use common\models\User;

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
            [['id', 'game_id', 'players', 'maxplayers', 'average_online', 'maximum_online', 'offline_count', 'rating_up', 'rating_down', 'status'], 'integer'],
            [['ip', 'port', 'title', 'title_eng', 'mode', 'language', 'version', 'site', 'created_at'], 'safe'],
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
        $query = Servers::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            'pagination' => [
                'pageSize' => 100,
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
            'average_online' => $this->average_online,
            'maximum_online' => $this->maximum_online,
            'offline_count' => $this->offline_count,
            'rating' => $this->rating,
            'rating_up' => $this->rating_up,
            'rating_down' => $this->rating_down,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'port', $this->port])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'title_eng', $this->title_eng])
            ->andFilterWhere(['like', 'mode', $this->mode])
            ->andFilterWhere(['like', 'language', $this->language])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'site', $this->site]);

        return $dataProvider;
    }
}
