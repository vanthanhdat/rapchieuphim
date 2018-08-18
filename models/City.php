<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property int $id
 * @property string $cityname
 *
 * @property Rap[] $raps
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cityname'], 'required'],
            [['cityname'], 'string', 'max' => 50],
            ['cityname', 'unique','message' => 'Thành phố này đã có, vui lòng kiểm tra lại!']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cityname' => 'Tên thành phố',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRaps()
    {
        return $this->hasMany(Rap::className(), ['idcity' => 'id']);
    }
}
