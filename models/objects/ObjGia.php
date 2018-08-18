<?php 
namespace app\models\objects;
use Yii;
use yii\base\Model;

/**
 * summary
 */
class ObjGia extends Model
{

   public $days = [
                    'MondayWednesdayThursday' => 'Thứ 2, 4, 5',
                    'Tuesday' => 'Thứ 3 Happy day',
                    'Friday' => 'Thứ sáu',
                    'SaturdaySunday' => 'Thứ 7, Chủ nhật',
                    'holidays' => 'Ngày lễ',
                   // 'trian' => 'Tri Ân'
                ];
   public function __construct($params)
   {
   		if ($params === null) {
	   			foreach ($this->days as $key => $value) {
	   	   		$this->{$key.'_before'} = '' ;
	   	   		$this->{$key.'_after'} = '';
	   	   }
   		}else{
   			foreach ($params as $key => $value) {
   				$this->{$key} = $value;
   			}
   		}
   }
   
   	public function __set($key, $value)
    {
        $this->{$key} = $value;
    }

    public function __get($value)
    {
        return $value;
    }

   public function rules()
    {
    	$config = [];
    	foreach ($this->days as $key => $value) {
    		array_push($config,[[''.$key.'_before', ''.$key.'_after',],'required','message'=>'{attribute} không được để trống !'],
    			[[''.$key.'_before'], 'integer','min' => 40000 ,'max' => 80000],
	          	[[''.$key.'_after'], 'integer','min' => 40000 ,'max' => 150000],
	          [[''.$key.'_after'], 'compare', 'compareAttribute' => ''.$key.'_before', 'operator' => '>=']);
    	}
        return $config;
    }


    public function attributeLabels()
    {
    	$config = [];
    	foreach ($this->days as $key => $value) {
    		$config[''.$key.'_before'] = 'Trước 17 giờ:';
    		$config[''.$key.'_after'] = 'Sau 17 giờ:';
    	}
    	return $config;
    }
}
?>