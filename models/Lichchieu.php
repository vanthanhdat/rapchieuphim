<?php

namespace app\models;

use Yii;

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
class Lichchieu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
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
