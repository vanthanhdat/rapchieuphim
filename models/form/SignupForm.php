<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\User;

class SignupForm extends User
{
	public $email;
	public $password;
	public $hoten;
	public $address;
	public $sdt;
	public $cmnd;
	public $gender;
	public $birthDate;

	
	public function signup()
	{
		if (!$this->validate()) {
			return null;
		}
		$user = new User();
		$user->email = $this->email;
		$user->setPassword($this->password);
		$user->hoten = $this->hoten;
		$user->address = $this->address;
		$user->sdt = $this->sdt;
		$user->cmnd = $this->cmnd;
		$user->gender = $this->gender;
		$user->birthDate = date('Y-m-d', strtotime($this->birthDate));
		$user->generateAuthKey();
		 if ($user->save()) {
		 		$user->touch('last_login');
	            return $user;
	        }
	}
}

?>