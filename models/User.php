<?php

namespace app\models;

use yii;
use yii\base\NotSupportedException;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


class User extends ActiveRecord implements \yii\web\IdentityInterface
{
  
   // const SCENARIO_LOGIN = 'login';
   // const SCENARIO_REGISTER = 'register';
    const ROLE_USER = 0;
    const ROLE_ADMIN = 1;
    public static function tableName()
    {
        return '{{%user}}';
    }

    /*
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_LOGIN] = ['username', 'password'];
        $scenarios[self::SCENARIO_REGISTER] = ['username', 'email', 'password'];
        return $scenarios;
    }
     */
     

    public function rules()
    {
        return [        
            [['email', 'password','hoten','sdt','address','gender','birthDate','cmnd'],'required','message'=>'{attribute} không được để trống !'],
            ['email','trim'],
            ['email','email','message' => 'Địa chỉ email không hợp lệ !'],
            ['email','string','max' => 255],
            [['cmnd'], 'integer'],
            ['cmnd','string','max' => 11 ,'min' => 8,
                'tooShort' => 'Số chứng minh quá ngắn, không hợp lệ!',
                'tooLong' => 'Số chứng minh quá dài, không hợp lệ!'],
            ['cmnd','unique','targetClass' => 'app\models\User','message' => 'Số chứng minh đã được sử dụng, vui lòng chọn số khác !'],   
            ['email','unique','targetClass' => 'app\models\User','message' => 'Email đã được sử dụng, vui lòng chọn email khác !'],     
            ['password','string','min' => 6],
            ['hoten','string','max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'address' => 'Địa chỉ','sdt'=>'Điện thoại','gender' => 'Giới tính','hoten' => 'Họ tên',
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
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::findOne(['email' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return true if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password,$this->password);
    }

    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }

    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }
}
