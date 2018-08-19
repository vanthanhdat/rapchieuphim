<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "phim".
 *
 * @property int $Id
 * @property string $title
 * @property string $tomtat
 * @property string $nhasanxuat
 * @property string $image
 * @property int $thoiluong
 * @property string $quocgia
 * @property string $dienvien
 * @property int $id_tl
 * @property int $id_dd
 * @property int $created_at
 * @property int $updated_at
 * @property string $start
 *
 * @property Lichchieu[] $lichchieus
 * @property Daodien $dd
 * @property Theloai $tl
 */
class Phim extends ActiveRecord
{
    const STATUS = [
        ['key' => 0,'value' => 'Ngưng chiếu'],
        ['key' => 1,'value' => 'Sắp chiếu'],
        ['key' => 2,'value' => 'Đang chiếu'],
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'phim';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_dd'], 'exist', 'skipOnError' => true, 'targetClass' => Daodien::className(), 'targetAttribute' => ['id_dd' => 'id']],
            [['id_tl'], 'exist', 'skipOnError' => true, 'targetClass' => Theloai::className(), 'targetAttribute' => ['id_tl' => 'Id']],
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
            'tomtat' => 'Tóm tắt phim',
            'nhasanxuat' => 'Nhà sản xuất',
            'image' => 'Hình ảnh',
            'thoiluong' => 'Thời lượng',
            'quocgia' => 'Quốc gia',
            'dienvien' => 'Diễn viên',
            'id_tl' => 'Thể loại',
            'id_dd' => 'Đạo diễn',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'start' => 'Bắt đầu chiếu',
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
    public function getLichchieus()
    {
        return $this->hasMany(Lichchieu::className(), ['idphim' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDd()
    {
        return $this->hasOne(Daodien::className(), ['id' => 'id_dd']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTl()
    {
        return $this->hasOne(Theloai::className(), ['id' => 'id_tl']);
    }

}
