<?php 
namespace app\models\objects;
use Yii;
use yii\base\Model;
use app\models\Phim;
/**
 * summary
 */
class ObjPhim extends Model
{
    /**
     * summary
     */
    
    public $id;
    public $title;
    public $tomTat;
    public $nhaSanXuat;
    public $image;
    public $thoiLuong;
    public $quocGia;
    public $dienVien;
    public $id_tl;
    public $id_dd;
    public $start;
    public $trailerUrl;
    public $created_at;
    public $updated_at;
    public $status;
    public $slug;

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function rules()
    {
        return [
            [['title', 'tomTat', 'nhaSanXuat','thoiLuong', 'quocGia', 'dienVien', 'id_tl', 'id_dd', 'start','trailerUrl'], 'required','message' => '{attribute} không thể để trống !'],
            [['tomTat'], 'string'],
            [['thoiLuong', 'id_tl', 'id_dd', 'created_at', 'updated_at'], 'integer'],
            [['thoiLuong'], 'integer', 'max' => 150],
            [['start'], 'safe'],
            [['title', 'nhaSanXuat', 'quocGia', 'dienVien'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Tựa phim',
            'tomTat' => 'Tóm tắt phim',
            'nhaSanXuat' => 'Nhà sản xuất',
            'image' => 'Hình ảnh',
            'thoiLuong' => 'Thời lượng',
            'quocGia' => 'Quốc gia',
            'dienVien' => 'Diễn viên',
            'id_tl' => 'Thể loại',
            'id_dd' => 'Đạo diễn',
            'created_at' => 'Đã thêm lúc',
            'updated_at' => 'Cập nhật lúc',
            'start' => 'Bắt đầu chiếu',
            'trailerUrl' => 'Đường dẫn video trailer',
            'status' => 'Trạng thái'
        ];
    }


    public function uploadImagePhim($slug)
    {
        if ($this->validate() && $this->image!=null) {
            $path = Yii::getAlias('@img');
            $this->image->saveAs($path.'/phim'.'/'. $slug . '.' . $this->image->extension);
            $src = imagecreatefromjpeg($path.'/phim'.'/'. $slug . '.' . $this->image->extension);
            list($width,$height) = getimagesize($path.'/phim'.'/'. $slug . '.' . $this->image->extension);
            $newWidth = 300;
            $newHeight = 450;
            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($newImage,$src,0,0,0,0,$newWidth,$newHeight,$width,$height);
            imagejpeg($newImage,$path.'/phim'.'/'. $slug . '.' . $this->image->extension,100);
            imagedestroy($src);
            imagedestroy($newImage);
            return true;
        } else {
            return false;
        }
    }

    public function deleteFile($path)
    {
        if (file_exists($path)) {
            unlink($path);
            return true;
        }
        return false;
    }


    public function createPhim()
    {
        $date = new \DateTime();
        $phim = new Phim();
        $phim->id_tl = $this->id_tl;
        $phim->id_dd = $this->id_dd;
        $phim->slug = implode('-',explode(' ',$this->remove_vietnamese_accents(str_replace([':','/',],'',$this->title)))).'-'.date_timestamp_get($date);
        $attributes = array(
            'title' => $this->title,
            'tomtat' => $this->tomTat,
            'nhasanxuat' => $this->nhaSanXuat,
            'image' => $this->image != null ? $phim->slug . '.' . $this->image->extension : '',
            'thoiluong' => $this->thoiLuong,
            'quocgia' => $this->quocGia,
            'dienvien' => $this->dienVien,
            'start' => $this->start,
            'trailerurl' => $this->trailerUrl
        );
        $phim->attributes = json_encode($attributes);
        if ($phim->save()) {
            $this->uploadImagePhim($phim->slug);
            return true;
        }
        return false;    
    }

    public function updatePhim($id)
    {
        $date = new \DateTime();
        $phim = Phim::findOne($id);
        $phim->id_tl = $this->id_tl;
        $phim->id_dd = $this->id_dd;
        $phim->status = $this->status;
        $oldAttributes = json_decode($phim->attributes);
        $newAttributes = array(
            'title' => $this->title,
            'tomtat' => $this->tomTat,
            'nhasanxuat' => $this->nhaSanXuat,
            'image' => '',
            'thoiluong' => $this->thoiLuong,
            'quocgia' => $this->quocGia,
            'dienvien' => $this->dienVien,
            'start' => $this->start,
            'trailerurl' => $this->trailerUrl
        );
        if ($this->image === null) {
            $newAttributes['image'] = $oldAttributes->image;
        }else{
            $pathFile ='';
            if ($oldAttributes->image !== '') {
                $pathFile = Yii::getAlias('@img').'/phim'.'/'.$oldAttributes->image;
                $this->deleteFile($pathFile);
            }
            $this->uploadImagePhim($phim->slug);
            $newAttributes['image'] = $phim->slug . '.' . $this->image->extension;
        }
        $phim->attributes = json_encode($newAttributes);

        if ($phim->save()) {
            return true;
        }
        return false;
    }

    public function getObject($id)
    {
        $phim = Phim::findOne($id);
        $this->id = $phim->id;
        $this->created_at = $phim->created_at;
        $this->updated_at = $phim->updated_at;
        $this->status = $phim->status;
        $this->id_dd = $phim->id_dd;
        $this->id_tl = $phim->id_tl;
        $this->slug = $phim->slug;
        $attributes = json_decode($phim->attributes);
        $this->title = $attributes->title;
        $this->tomTat = $attributes->tomtat;
        $this->nhaSanXuat = $attributes->nhasanxuat;
        $this->image = $attributes->image;
        $this->thoiLuong = $attributes->thoiluong;
        $this->quocGia = $attributes->quocgia;
        $this->dienVien = $attributes->dienvien;
        $this->start = $attributes->start;
        $this->trailerUrl = $attributes->trailerurl;
        return $this;
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