<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
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
            [['ngaychieu', 'giochieu', 'idphim', 'idphong'], 'required'],
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

    /**
     * {@inheritdoc}
     * @return LichchieuQuery the active query used by this AR class.
     */
}
