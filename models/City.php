<?php

namespace app\models;

use Yii;
use  yii\db\Query;
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
    const INACTIVE = 0;
    const ACTIVE = 1;
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

    public function queryCities($param,$page)
    {
        $cities = [];
        if ($param !== '') {
            $cities = (new \yii\db\Query())->select(['id', 'cityname'])->from('city')->where(['like', 'cityname', $param])->andWhere(['active' => City::ACTIVE])->all();       
        }else{
            $pageSize = 5;
            $query = City::find();
            $cities = $query->offset(($page-1)*$pageSize)->limit($pageSize)->where(['active' => City::ACTIVE])->orderBy(['cityname' => SORT_ASC])->asArray()->all();
        }
        return json_encode(['cities' => $cities]);
    }
}
