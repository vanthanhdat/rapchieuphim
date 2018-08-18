<?php 
namespace app\models\objects;
use Yii;
use yii\base\Model;
use app\models\Rap;
use app\models\objects\ObjGia;
/**
 * summary
 */
class ObjRap extends Model
{
    /**
     * summary
     */
   public $id;
   public $name;
   public $address;
   public $phone;
   public $description;
   public $city_id;
   public $created_at;
   public $updated_at;
   public $gia;
   public function rules()
    {
        return [        
            [['name', 'address','phone','description','details','city_id'],'required','message'=>'{attribute} không được để trống !'],
            ['name','string','max' => 50],
            [['phone'], 'integer',],
            ['phone','string','max' => 11 ,'min' => 8,
             'tooShort' => 'Số điện thoại quá ngắn, không hợp lệ!',
             'tooLong' => 'Số điện thoại quá dài, không hợp lệ!'],
        ];
    }
    public function attributeLabels()
    {
    	return [
            'name' => 'Tên rạp',
            'description' => 'Mô tả rạp',
            'phone' => 'Điện thoại',
            'details' => 'Chi tiết giá vé',
             'city_id' => 'Thành phố',
        ];
    }

    public function createRap($objGia)
    {
    	$id = 0;
    	$rap = new Rap();
    	$rap->idcity = $this->city_id;
      $attributes = array('name' => $this->name,
        			  'address' => $this->address,
        			  'phone' => $this->phone,
                      'description' => $this->description);
        $rap->attributes = json_encode($attributes);
        $rap->giave = $objGia;
        if ($rap->save()) {
            $id = $rap->id;
        }
        return $id;
    }
      
    public function save($params)
    {
    	$rap = Rap::findOne($this->id);
    	$rap->idcity = $this->city_id;
        $attributes = array('name' => $this->name,
        			  'address' => $this->address,
        			  'phone' => $this->phone,
                      'description' => $this->description);
        $rap->attributes = json_encode($attributes);
        $rap->giave = $params;
        if ($rap->save()) {
            return true;
        }
        return false;
    }
}
?>