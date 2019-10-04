<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AdvertisingBanners as AdvertisingBannersModel;

/**
 * AdvertisingBanners represents the model behind the search form of `common\models\AdvertisingBanners`.
 */
class AdvertisingBanners extends AdvertisingBannersModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'title', 'status', 'buy_id', 'price'], 'integer'],
            [['size'], 'safe'],
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
        $query = AdvertisingBannersModel::find();

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
            'title' => $this->title,
            'status' => $this->status,
            'buy_id' => $this->buy_id,
            'price' => $this->price,
        ]);

        $query->andFilterWhere(['like', 'size', $this->size]);

        return $dataProvider;
    }
}
