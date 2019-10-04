<?php

namespace frontend\models\search\freelance;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\FreelanceVacancies as FreelanceVacanciesModel;

/**
 * FreelanceVacancies represents the model behind the search form of `common\models\FreelanceVacancies`.
 */
class VacanciesSearch extends FreelanceVacanciesModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'server_id', 'vacancie_id', 'work_time', 'status'], 'integer'],
            [['text', 'date'], 'safe'],
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
        $query = FreelanceVacanciesModel::find()
            ->orderBy(['date' => SORT_DESC]);

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
            'vacancie_id' => $this->vacancie_id,
            'work_time' => $this->work_time,
        ]);

        $query->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
