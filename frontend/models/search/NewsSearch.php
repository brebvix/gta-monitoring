<?php

namespace frontend\models\search;

use common\models\NewsCategories;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\News as NewsModel;

/**
 * News represents the model behind the search form of `common\models\News`.
 */
class NewsSearch extends NewsModel
{
    public $category;

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
        $query = NewsModel::find()
            ->with('categorie')
            ->where(['language' => Yii::$app->language]);

        if (!empty($this->category)) {
            $category = NewsCategories::findOne(['title_eng' => $this->category]);

            if (!empty($category)) {
                $query->andWhere(['categorie_id' => $category->id]);
            }
        }

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
