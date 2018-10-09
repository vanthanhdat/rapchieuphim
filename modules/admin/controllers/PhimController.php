<?php

namespace app\modules\admin\controllers;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;
use  yii\db\Query;
use app\models\Phim;

class PhimController extends \yii\web\Controller
{

	public function behaviors()
	{
		return [
			'access' => [
				'class' => \yii\filters\AccessControl::className(),
				'ruleConfig' => [
					'class' => AccessRule::className(),
				],
				'rules' => [
					[
						'allow' => true,
						'roles' => [
							User::ROLE_ADMIN
						],
					],
				],
			],
			/*'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => ['delete' =>['post']],
			],*/
		];
	}

	public function beforeAction($action)
	{
		$this->enableCsrfValidation = false;
		return parent::beforeAction($action);
	}

	public function actionIndex()
	{
		return $this->render('index');
	}

}
