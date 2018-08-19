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
    public $created_at;
    public $updated_at;



    public function rules()
    {
        return [
            [['title', 'tomTat', 'nhaSanXuat','image','thoiLuong', 'quocGia', 'dienVien', 'id_tl', 'id_dd', 'start'], 'required','message' => '{attribute} không thể để trống !'],
            [['tomTat'], 'string'],
            [['thoiLuong', 'id_tl', 'id_dd', 'created_at', 'updated_at'], 'integer'],
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
        ];
    }


    public function uploadImagePhim()
    {
        $fileName =  implode("-",explode(" ",$this->title));  
        if ($this->validate()) {
            $path = Yii::getAlias('@img');
            $this->image->saveAs($path.'/phim'.'/'. $fileName . '.' . $this->image->extension);
            return true;
        } else {
            return false;
        }
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
            'image' => implode("-",explode(" ",$this->title)). '.' .$this->image->extension,
            'thoiluong' => $this->thoiLuong,
            'quocgia' => $this->quocGia,
            'dienvien' => $this->dienVien,
            'start' => $this->start
        );
        $phim->attributes = json_encode($attributes);
        if ($phim->save()) {
            $this->uploadImagePhim();
          	return true;
        }
        return false;    
    }

}
?>