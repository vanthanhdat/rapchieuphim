<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "rap".
 *
 * @property int $Id
 * @property string $attributes
 * @property string $giave
 * @property int $idcity
 *
 * @property Phongchieu[] $phongchieus
 * @property City $city
 */
class Rap extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rap';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['attributes', 'idcity'], 'required'],
            [['attributes',], 'string'],
            [['idcity'], 'integer'],
            [['idcity'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['idcity' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'attributes' => 'Attributes',
            'idcity' => 'Idcity',
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
    public function getPhongchieus()
    {
        return $this->hasMany(Phongchieu::className(), ['idrap' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'idcity']);
    }
}
