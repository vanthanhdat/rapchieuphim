<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "theloai".
 *
 * @property int $Id
 * @property string $name
 *
 * @property Phim[] $phims
 */
class Theloai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'theloai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'name' => 'Tên thể loại',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhims()
    {
        return $this->hasMany(Phim::className(), ['id_tl' => 'id']);
    }
}
