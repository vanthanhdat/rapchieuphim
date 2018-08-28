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


    public function uploadImagePhim()
    {
        if ($this->validate() && $this->image!=null) {
            $path = Yii::getAlias('@img');
            $this->image->saveAs($path.'/phim'.'/'. $this->image->name);
            $src = imagecreatefromjpeg($path.'/phim'.'/'. $this->image->name);
            list($width,$height) = getimagesize($path.'/phim'.'/'. $this->image->name);
            $newWidth = 300;
            $newHeight = 450;
            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($newImage,$src,0,0,0,0,$newWidth,$newHeight,$width,$height);
            imagejpeg($newImage,$path.'/phim'.'/'. $this->image->name,100);
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
    	$phim = new Phim();
        $phim->id_tl = $this->id_tl;
        $phim->id_dd = $this->id_dd;
        $attributes = array(
            'title' => $this->title,
            'tomtat' => $this->tomTat,
            'nhasanxuat' => $this->nhaSanXuat,
            'image' => $this->image != null ? $this->image->name : '',
            'thoiluong' => $this->thoiLuong,
            'quocgia' => $this->quocGia,
            'dienvien' => $this->dienVien,
            'start' => $this->start,
            'trailerurl' => $this->trailerUrl
        );
        $phim->attributes = json_encode($attributes);
        if ($phim->save()) {
            $this->uploadImagePhim();
          	return true;
        }
        return false;    
    }

    public function updatePhim($id)
    {
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
            $this->uploadImagePhim();
            $newAttributes['image'] = $this->image->name;
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
}
?>