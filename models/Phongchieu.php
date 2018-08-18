<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\components\UniqueAttributesValidator;
/**
 * This is the model class for table "phongchieu".
 *
 * @property int $id
 * @property string $name
 * @property string $sodo
 * @property int $idrap
 *
 * @property Lichchieu[] $lichchieus
 * @property Rap $rap
 */
class Phongchieu extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'phongchieu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'sodo', 'idrap'], 'required','message'=>'{attribute} không được để trống !'],
            [['sodo'], 'string'],
            [['idrap'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['idrap'], 'exist', 'skipOnError' => true, 'targetClass' => Rap::className(), 'targetAttribute' => ['idrap' => 'id']],
            ['name', 'unique','targetClass' => Phongchieu::className() ,'message' => 'Phòng này đã tồn tại trong rạp này, vui lòng kiểm tra lại!','targetAttribute' => ['name', 'idrap'],]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Tên phòng',
            'sodo' => 'Sơ đồ',
            'idrap' => 'Idrap',
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
        return $this->hasMany(Lichchieu::className(), ['idphong' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRap()
    {
        return $this->hasOne(Rap::className(), ['id' => 'idrap']);
    }
}
