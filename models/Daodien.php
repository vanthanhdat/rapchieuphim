<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "daodien".
 *
 * @property int $id
 * @property string $profiles
 * @property string $quoctich
 *
 * @property Phim[] $phims
 */
class Daodien extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'daodien';
    }

    /**
     * {@inheritdoc}
     */

    /**
     * {@inheritdoc}
     */
    
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
    public function getPhims()
    {
        return $this->hasMany(Phim::className(), ['id_dd' => 'id']);
    }
}
