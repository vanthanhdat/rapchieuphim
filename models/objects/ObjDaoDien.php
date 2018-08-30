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
    public $slug;
    public $created_at;
    public $updated_at;
    public $views;

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

    public function uploadImageDaoDien($slug)
    {
        if ($this->validate()) {
           // $date = new \DateTime();
           // $imageName = implode('-',explode(' ',$this->remove_vietnamese_accents($this->name))).'-'.date_timestamp_get($date);
            $path = Yii::getAlias('@img');
            $this->image->saveAs($path.'/daodien'.'/'. $slug . '.' . $this->image->extension);
            $src = imagecreatefromjpeg($path.'/daodien'.'/'. $slug . '.' . $this->image->extension);
            list($width,$height) = getimagesize($path.'/daodien'.'/'. $slug . '.' . $this->image->extension);
            $newWidth = 400;
            $newHeight = 400;
            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($newImage,$src,0,0,0,0,$newWidth,$newHeight,$width,$height);
            imagejpeg($newImage,$path.'/daodien'.'/'. $slug . '.' . $this->image->extension,100);
            imagedestroy($src);
            imagedestroy($newImage);
            return true;
        } else {
            return false;
        }
    }


    public function setObject($image,$oldAttributes)
    {
        $date = new \DateTime();
        $this->slug = implode('-',explode(' ',$this->remove_vietnamese_accents($this->name))).'-'.date_timestamp_get($date);
        $allAttributes = '';
        if ($oldAttributes === null) {
            if ($image === null) {
                $array = array(
                   'name' => $this->name, 
                   'description' => $this->description,
                   'birthdate' => $this->birthdate,
                   'image' => '',
                   'tieusu' => $this->tieusu);
                $allAttributes = json_encode($array);
            }
            else {
                $this->uploadImageDaoDien($this->slug);
                $array = array('name' => $this->name,                         
                    'description' => $this->description,
                    'birthdate' => $this->birthdate,
                    'image' => $this->slug . '.' . $this->image->extension,
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
                $this->uploadImageDaoDien($this->slug);
                $array = array('name' => $this->name, 
                    'description' => $this->description,
                    'birthdate' => $this->birthdate,
                    'image' => $this->slug . '.' . $this->image->extension,
                    'tieusu' => $this->tieusu);
                $allAttributes = json_encode($array);
            }
        }
        return $allAttributes;
    }
    
    public function createDaoDien()
    {
        $date = new \DateTime();
        $id = 0;
        $daodien = new Daodien();
        $daodien->quoctich = $this->quoctich;
        $daodien->slug = implode('-',explode(' ',$this->remove_vietnamese_accents($this->name))).'-'.date_timestamp_get($date);
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
        $daodien->attributes = $this->setObject($this->image,$daodien->attributes);
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
            $objDaoDien->slug = $params[$i]->slug;
            $objDaoDien->quoctich = $params[$i]->quoctich;
            $objDaoDien->created_at = $params[$i]->created_at;
            $objDaoDien->updated_at = $params[$i]->updated_at;
            $objDaoDien->views = $params[$i]->views;
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

public function remove_vietnamese_accents($str)
{
    $accents_arr=array(
        "à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
        "ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề",
        "ế","ệ","ể","ễ",
        "ì","í","ị","ỉ","ĩ",
        "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ",
        "ờ","ớ","ợ","ở","ỡ",
        "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
        "ỳ","ý","ỵ","ỷ","ỹ",
        "đ",
        "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă",
        "Ằ","Ắ","Ặ","Ẳ","Ẵ",
        "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
        "Ì","Í","Ị","Ỉ","Ĩ",
        "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ",
        "Ờ","Ớ","Ợ","Ở","Ỡ",
        "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
        "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
        "Đ"
    );
    $no_accents_arr=array(
        "a","a","a","a","a","a","a","a","a","a","a",
        "a","a","a","a","a","a",
        "e","e","e","e","e","e","e","e","e","e","e",
        "i","i","i","i","i",
        "o","o","o","o","o","o","o","o","o","o","o","o",
        "o","o","o","o","o",
        "u","u","u","u","u","u","u","u","u","u","u",
        "y","y","y","y","y",
        "d",
        "A","A","A","A","A","A","A","A","A","A","A","A",
        "A","A","A","A","A",
        "E","E","E","E","E","E","E","E","E","E","E",
        "I","I","I","I","I",
        "O","O","O","O","O","O","O","O","O","O","O","O",
        "O","O","O","O","O",
        "U","U","U","U","U","U","U","U","U","U","U",
        "Y","Y","Y","Y","Y",
        "D"
    );

    return str_replace($accents_arr,$no_accents_arr,$str);
}
}

?>