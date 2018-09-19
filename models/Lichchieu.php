<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Query;
use app\models\Phim;
use app\models\Rap;
/**
 * This is the model class for table "lichchieu".
 *
 * @property int $id
 * @property string $ngaychieu
 * @property string $giochieu
 * @property int $gia
 * @property int $idphim
 * @property int $idphong
 * @property int $created_at
 * @property int $updated_at
 * @property string $selected_seat
 *
 * @property Phim $phim
 * @property Phongchieu $phong
 * @property Ve[] $ves
 */
class Lichchieu extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const DAYS_OF_WEEK = [
        'Monday' => 'Thứ hai',
        'Tuesday' => 'Thứ ba',
        'Wednesday' => 'Thứ tư',
        'Thursday' => 'Thứ năm',
        'Friday' => 'Thứ sáu',
        'Saturday' => 'Thứ bảy',
        'Sunday' => 'Chủ nhật'
    ];
    public static function tableName()
    {
        return 'lichchieu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ngaychieu', 'giochieu', 'idphim', 'idphong'], 'required','message'=>'{attribute} không được để trống !'],
            [['ngaychieu', 'giochieu'], 'safe'],
            [['gia', 'idphim', 'idphong', 'created_at', 'updated_at'], 'integer'],
            [['selected_seat'], 'string'],
            [['idphim'], 'exist', 'skipOnError' => true, 'targetClass' => Phim::className(), 'targetAttribute' => ['idphim' => 'id']],
            [['idphong'], 'exist', 'skipOnError' => true, 'targetClass' => Phongchieu::className(), 'targetAttribute' => ['idphong' => 'id']],
            ['idphim', 'unique','targetClass' => Lichchieu::className() ,'message' => 'Lịch chiếu bạn muốn thêm đã tồn tại,vui lòng kiểm tra lại!','targetAttribute'=> ['idphim', 'ngaychieu','giochieu'],]
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ngaychieu' => 'Ngày chiếu',
            'giochieu' => 'Giờ chiếu',
            'gia' => 'Giá vé',
            'idphim' => 'Phim',
            'idphong' => 'Phòng',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'selected_seat' => 'Các ghế được đặt',
        ];
    }


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhim()
    {
        return $this->hasOne(Phim::className(), ['id' => 'idphim']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhong()
    {
        return $this->hasOne(Phongchieu::className(), ['id' => 'idphong']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVes()
    {
        return $this->hasMany(Ve::className(), ['id_lichchieu' => 'id']);
    }

    public function createLichChieu($idRap)
    {
        $times = Yii::$app->params['time_start_end'];
        $phim = Phim::findOne($this->idphim);
        $phimAttr = json_decode($phim->attributes);
        $start = $phimAttr->start;
        $check = Lichchieu::find()->Where(['idphim' => $this->idphim])->all();
        if (empty($check) && date("Y-m-d", strtotime($start)) !== date("Y-m-d", strtotime($this->ngaychieu))) {
            $session = Yii::$app->session;
            $session->addFlash('errorMessage');
            $session->setFlash('errorMessage', 'Bộ phim "'.$phimAttr->title.'" chưa có lịch chiếu, vui lòng chọn ngày chiếu khóp với ngày bắt đầu !');
            return false;
        }
        else{
           if (strtotime($this->giochieu) >= strtotime($times['start']) && strtotime($this->giochieu) <= strtotime($times['end'])) {
             $lich = new Lichchieu();
             $lich->ngaychieu = date('Y-m-d',strtotime($this->ngaychieu));
             $lich->giochieu = $this->giochieu;
             $rap = Rap::findOne($idRap);
             $gia = json_decode($rap->giave);
             $date = date('l',strtotime($this->ngaychieu));
             $giaVe = [];
             foreach ($gia as $key => $value) {
                if (strpos($key, $date) !== false) {
                    $keyGia = explode('_',$key);
                    $giaVe[$keyGia[1]] = $value;
                }
            }
            if ($this->giochieu < '17:00') {
                $lich->gia = $giaVe['before'];
            }
            else{
                $lich->gia = $giaVe['after'];
            }
            $lich->idphim = $this->idphim;
            $lich->idphong = $this->idphong;
            $lich->selected_seat = '';
            if ($this->checkPhim($idRap,$this->ngaychieu,$this->giochieu,$this->idphim)) {
               return $lich->save();
           }
           $session = Yii::$app->session;
           $session->addFlash('errorMessage');
           $session->setFlash('errorMessage', 'Lịch chiếu này đã tồn tại trong khoảng thời gian gần đó, không thể thêm!');
           return false;
       }
       else{
        $session = Yii::$app->session;
        $session->addFlash('errorMessage');
        $session->setFlash('errorMessage', 'Giờ chiếu phải nằm trong khoảng từ '.$times['start'].' đến '.$times['end'].', vui lòng kiểm tra lại !');
        return false;
    }
}
return false;
}

public function updateLichChieu($id)
{
    $lich = Lichchieu::findOne($id);
    $times = Yii::$app->params['time_start_end'];
    $lich->idphong = $this->idphong;
    if (strtotime($this->giochieu) >= strtotime($times['start']) && strtotime($this->giochieu) <= strtotime($times['end'])) {
        $lich->giochieu = $this->giochieu;
        $session = Yii::$app->session;
        $session->addFlash('flashMessage');
        $session->setFlash('flashMessage', 'Cập nhật thành công!');
        return $lich->save();
    }
    else{
        $session = Yii::$app->session;
        $session->addFlash('errorMessage');
        $session->setFlash('errorMessage', 'Giờ chiếu phải nằm trong khoảng từ '.$times['start'].' đến '.$times['end'].', vui lòng kiểm tra lại !');
        return false;
    }
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
