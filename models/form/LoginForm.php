<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\User;


/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;
    private $_user = false;


    
    /**
     * @return array the validation rules.
     */

    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'required','message'=>'{attribute} không được để trống !'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            ['email','email','message' => 'Địa chỉ email không hợp lệ .'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }
    
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Tài khoản và mật khẩu không đúng!');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $user->touch('last_login');
            return Yii::$app->user->login($user, $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }


    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->email);
        }
        return $this->_user;
    }
}
