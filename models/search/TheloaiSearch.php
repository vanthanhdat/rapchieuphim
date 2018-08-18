<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Theloai;
use yii\data\Pagination;

/**
 * TheloaiSearch represents the model behind the search form of `app\models\Theloai`.
 */
class TheloaiSearch extends Theloai
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'safe'],
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
        $query = Theloai::find();

        $pagination = new Pagination([
            'totalCount' => $query->count(),
        ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit(5),
            'pagination' => [
                'pageSize'=> 5,
                'totalCount' => $query->count()
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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
