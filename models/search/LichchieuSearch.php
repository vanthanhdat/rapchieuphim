<?php 
namespace app\models\search;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Lichchieu;
use yii\data\Pagination;
use yii\db\Query;

/**
 * summary
 */
class LichchieuSearch extends Lichchieu
{
    /**
     * summary
    */
    public function rules()
    {
    	return [
    		[['id'], 'integer'],
    		[['idphong','idphim','ngaychieu','giochieu'], 'safe'],
    	];
    }


    public function search($id,$params)
    {
    	$query = Lichchieu::find()->where(['>=','ngaychieu',date("Y-m-d")])->orderBy(['ngaychieu' => SORT_ASC]);
    	$query->joinWith('phong')->andWhere(['idrap' => $id]);
    	$query->joinWith('phim');
    	$pagination = new Pagination([
    		'totalCount' => $query->count(),
    	]);
    	$dataProvider = new ActiveDataProvider([
    		'query' => $query
    		->offset($pagination->offset)
    		->limit(5),
    		'pagination' => [
    			'pageSize'=> 2,
    			'totalCount' => $query->count()
    		],
    	]);
    	$this->load($params); 
    	if (!$this->validate()) {
    		return $dataProvider;
    	}
    	$query->andFilterWhere(['like', 'phim.attributes',$this->idphim]);
    	$query->andFilterWhere(['like', 'phongchieu.name', $this->idphong]);
        if ($this->ngaychieu) {
            $day = '';
            foreach ($this::DAYS_OF_WEEK as $key => $value) {
                if (strpos(strtolower($value), strtolower($this->ngaychieu))) {
                  $day =  $key;
              }
          }
          $query->andFilterWhere(['like', 'ngaychieu', date("Y-m-d",strtotime($day))]);
          $query->orFilterWhere(['like', 'ngaychieu', date("Y-m-d",strtotime($this->ngaychieu))]);
      }
      $query->andFilterWhere(['like', 'giochieu',$this->giochieu]);
      return $dataProvider;
  }
}
?>