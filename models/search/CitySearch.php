<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\City;
use yii\data\Pagination;


/**
 * CountrySearch represents the model behind the search form of `app\models\Country`.
 */
class CitySearch extends City
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['cityname'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // by pass scenarios() implementation in the parent class
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

        $query = City::find();
        
        $pagination = new Pagination([
            'totalCount' => $query->count(),
        ]);
        $offset = $pagination->offset;
        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy('cityname')
            ->offset($pagination->offset)
            ->limit(5),
            'pagination' => [
                'pageSize'=> 5,
                'totalCount' => $query->count()
            ],
        ]);

        $this->load($params);
        
        if (!$this->validate()) {
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere(['like', 'id', $this->id,
        ]);
        $query->andFilterWhere(['like', 'cityname', $this->cityname]);
        return $dataProvider;
    }
}
