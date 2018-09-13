<?php 
namespace app\models\objects;

use Yii;
use yii\base\Model;
use app\models\Lichchieu;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\data\Pagination;
use app\models\Phim;
use app\models\Rap;
/**
 * summary
 */
class ObjLichChieu extends Model
{
    /**
     * summary
     */
    public $id;
    public $ngayChieu;
    public $gioChieu;
    public $gia;
    public $phim;
    public $phong;
    public $selected_seat;
    public $created_at;
    public $updated_at;

    
    public function rules()
    {
        return [        
            [['ngayChieu', 'gioChieu','gia','phim','phong'],'required','message'=>'{attribute} không được để trống !'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'ngayChieu' => 'Ngày chiếu','gioChieu' => 'Giờ chiếu','phim' => 'Phim','phong' => 'Phòng',
        ];
    }



    public function createLichChieu($idRap)
    {
        $times = Yii::$app->params['time_start_end'];
        $phim = Phim::findOne($this->phim);
        $phimAttr = json_decode($phim->attributes);
        $start = $phimAttr->start;
        $check = Lichchieu::find()->Where(['idphim' => $this->phim])->all();
        if (empty($check) && date("Y-m-d", strtotime($start)) !== date("Y-m-d", strtotime($this->ngayChieu))) {
            $session = Yii::$app->session;
            $session->addFlash('errorMessage');
            $session->setFlash('errorMessage', 'Bộ phim "'.$phimAttr->title.'" chưa có lịch chiếu, vui lòng chọn ngày chiếu khóp với ngày bắt đầu !');
            return false;
        }
        else{
           if (strtotime($this->gioChieu) >= strtotime($times['start']) && strtotime($this->gioChieu) <= strtotime($times['end'])) {
             $lich = new Lichchieu();
             $lich->ngaychieu = date('Y-m-d',strtotime($this->ngayChieu));
             $lich->giochieu = $this->gioChieu;
             $rap = Rap::findOne($idRap);
             $gia = json_decode($rap->giave);
             $date = date('l',strtotime($this->ngayChieu));
             $giaVe = [];
             foreach ($gia as $key => $value) {
                if (strpos($key, $date) !== false) {
                    $keyGia = explode('_',$key);
                    $giaVe[$keyGia[1]] = $value;
                }
            }
            if ($this->gioChieu < '17:00') {
                $lich->gia = $giaVe['before'];
            }
            else{
                $lich->gia = $giaVe['after'];
            }
            $lich->idphim = $this->phim;
            $lich->idphong = $this->phong;
            $lich->selected_seat = '';
           // var_dump($this);
          //  var_dump($giaVe);
           // exit;
           if ($this->checkPhim($idRap,$this->ngayChieu,$this->gioChieu,$this->phim)) {
               return $lich->save();
           }
           $session = Yii::$app->session;
           $session->addFlash('errorMessage');
           $session->setFlash('errorMessage', 'Lịch chiếu này đã tồn tại, trong khoảng thời gian gần đó, không thể thêm!');
           return false;
       }
       else{
        $session = Yii::$app->session;
        $session->addFlash('errorMessage');
        $session->setFlash('errorMessage', 'Giờ chiếu phải nằm trong khoảng từ '.$times[0].' đến '.$times[1].', vui lòng kiểm tra lại !');
        return false;
    }
}
return false;
}



public function checkPhim($idRap,$ngayChieu,$gioChieu,$idPhim)
{
    $date = new \DateTime(date('Y-m-d',strtotime($ngayChieu)).$gioChieu);
    $date->modify('-180 minutes');
    $before = date('H:i:s',strtotime($date->format('H:i')));

    $date->modify('+360 minutes');
    $after = date('H:i:s',strtotime($date->format('H:i')));
    $check = (new Query())->select('phongchieu.id,name')->from('lichchieu')
    ->leftJoin('phongchieu', 'phongchieu.id = lichchieu.idphong')
    ->where(['=', 'lichchieu.ngaychieu', date('Y-m-d',strtotime($ngayChieu))])
    ->andWhere(['=', 'phongchieu.idrap', $idRap])
    ->andWhere(['and',
       ['>','lichchieu.giochieu', $before],
       ['<','lichchieu.giochieu', $after]
   ])->andWhere(['idphim' => $idPhim])->all();
    if (empty($check)) {
        return true;
    }
    return false;
}

}

?>