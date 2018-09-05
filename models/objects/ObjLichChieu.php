<?php 
namespace app\models\objects;

use Yii;
use yii\base\Model;
use app\models\Lichchieu;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\data\Pagination;
use app\models\Phim;
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
    public $created_at;
    public $updated_at;

    
    public function rules()
    {
        return [        
            [['ngayChieu', 'gioChieu','gia','phim','phong'],'required','message'=>'{attribute} không được để trống !'],
             ['phim', 'unique','targetClass' => Lichchieu::className() ,'message' => 'Lịch chiếu bạn muốn thêm đã tồn tại,vui lòng kiểm tra lại!','targetAttribute'=> ['idphim', 'ngaychieu','giochieu'],]
        ];
    }

    public function attributeLabels()
    {
        return [
            'ngayChieu' => 'Ngày chiếu','gioChieu' => 'Giờ chiếu','phim' => 'Phim','phong' => 'Phòng',
        ];
    }



    public function createLichChieu()
    {

        $lich = new Lichchieu();
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
           if (strtotime($this->gioChieu) >= strtotime($times[0]) && strtotime($this->gioChieu) <= strtotime($times[1])) {
               $session = Yii::$app->session;
               $session->addFlash('flashMessage');
               $session->setFlash('flashMessage', 'Ok');
               return true;
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
}

?>