<?php 
namespace app\models\objects;
use Yii;
use yii\base\Model;
use app\models\Daodien;
use yii\helpers\StringHelper;
/**
 * summary
 */
class ObjDaoDien extends Model
{
	public $id;
    public $name;
	public $description;
	public $birthdate;
	public $tieusu;
	public $image;
	public $quoctich;
    public $created_at;
    public $updated_at;


	
	public function rules()
    {
        return [        
            [['name', 'description','birthdate','tieusu','quoctich'],'required','message'=>'{attribute} không được để trống !'],
            ['name','string','max' => 50],
            ['quoctich','string','max' => 50],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    public function attributeLabels()
    {
    	return [
            'name' => 'Tên đạo diễn','description' => 'Mô tả','birthdate' => 'Ngày sinh','tieusu' => 'Tiểu sử','image' => 'Hình ảnh',
            'quoctich' => 'Quốc tịch',
        ];
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function uploadImageDaoDien()
    {
        if ($this->validate()) {
            $path = Yii::getAlias('@img');
            $this->image->saveAs($path.'/daodien'.'/'. $this->image->name);
            $src = imagecreatefromjpeg($path.'/daodien'.'/'. $this->image->name);
            list($width,$height) = getimagesize($path.'/daodien'.'/'. $this->image->name);
            $newWidth = 400;
            $newHeight = 400;
            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($newImage,$src,0,0,0,0,$newWidth,$newHeight,$width,$height);
            imagejpeg($newImage,$path.'/daodien'.'/'. $this->image->name,100);
            imagedestroy($src);
            imagedestroy($newImage);
            return true;
        } else {
            return false;
        }
    }


    public function setObject($image,$oldAttributes)
    {
        $allAttributes = '';
        if ($oldAttributes === null) {
            if ($image === null) {
                $array = array('name' => $this->name,
                              'description' => $this->description,
                              'birthdate' => $this->birthdate,
                              'image' => '',
                              'tieusu' => $this->tieusu);
                $allAttributes = json_encode($array);
            }
            else {
                $this->uploadImageDaoDien();
                $array = array(
                        'name' => $this->name,
                        'description' => $this->description,
                        'birthdate' => $this->birthdate,
                        'image' => $this->image->name,
                        'tieusu' => $this->tieusu);
                $allAttributes = json_encode($array);
            }
        } else {
            $obj = Daodien::findOne($this->id);
            $attributes = json_decode($obj->attributes);
            $oldImage = $attributes->image; 
            if ($image === null) {
                $array = array('name' => $this->name,
                 'description' => $this->description,
                  'birthdate' => $this->birthdate,
                  'image' => $oldImage,
                  'tieusu' => $this->tieusu);
                  $allAttributes = json_encode($array);
            }
            else {
                $pathFile ='';
                if ($oldImage !== '') {
                    $pathFile = Yii::getAlias('@img').'/daodien'.'/'.$oldImage;
                    $this->deleteFile($pathFile);
                }
                $this->uploadImageDaoDien();
                $array = array(
                'name' => $this->name,
                'description' => $this->description,
                'birthdate' => $this->birthdate,
                'image' => $this->image->name,
                'tieusu' => $this->tieusu);
                $allAttributes = json_encode($array);
            }
        }
        return $allAttributes;
    }
    
    public function createDaoDien()
    {
        $id = 0;
        $daodien = new Daodien();
        $daodien->quoctich = $this->quoctich;
        $daodien->attributes = $this->setObject($this->image,null);
        if ($daodien->save()) {
            $id = $daodien->id;
        }
        return $id;
    }

    public function deleteFile($path)
    {
        if (file_exists($path)) {
            unlink($path);
            return true;
        }
        return false;
    }


    //update Đạo diễn
    public function save($image)
    {
    	$daodien = Daodien::findOne($this->id);
        $daodien->attributes = $this->setObject($image,$daodien->attributes);
        $daodien->quoctich = $this->quoctich;
        if ($daodien->save()) {
            $session = Yii::$app->session;
            $session->addFlash('flashMessage');
            $session->setFlash('flashMessage', 'Cập nhật thành công !');
            return true;
        }
        return false; 
    }

    public static function getListObject($params)
    {
        $listObj = [];
        for ($i = 0; $i < count($params) ; $i++) {
            $objDaoDien = new ObjDaoDien();
            $objDaoDien->id = $params[$i]->id;
            $objDaoDien->quoctich = $params[$i]->quoctich;
            $objDaoDien->created_at = $params[$i]->created_at;
            $objDaoDien->updated_at = $params[$i]->updated_at;
            $attributes = json_decode($params[$i]->attributes);
            foreach ($attributes as $key => $value) {
                 $objDaoDien->__set($key,$value);
            }
            array_push($listObj, $objDaoDien);            
        }
        return $listObj;
    }

    public function getPreview()
    {
        $words = 40;
        if (StringHelper::countWords($this->description) > $words) {
            return StringHelper::truncateWords($this->description,$words);
        }
        return $this->description;
    }
}

?>