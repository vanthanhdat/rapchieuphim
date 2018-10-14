<?php

namespace app\modules\admin\controllers;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;
use  yii\db\Query;
use app\models\Phim;
use app\models\objects\ObjPhim;

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
						//'actions' => ['index','get-phims'],
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

	public function actionGetPhims()
	{
		$status = $_GET["status"];
		$phims = Phim::find()->where(['status' => $status])
		->orderBy(['created_at' => SORT_DESC])
		->all();
		//var_dump(json_encode(['phims' => $this->returnPhims($phims)]));exit;
		return json_encode(['phims' => $this->returnPhims($phims)]);
		//var_dump(json_encode($phims));
		//var_dump($phims);
		//var_dump($phimsReturn);exit;
		//exit;
	}

	protected function returnPhims($phims)
	{
		$phimsReturn = [];
		foreach ($phims as $key => $value) {
			$daodien = $value->dd;
			$theloai = $value->tl;
			$daoDienAttr = json_decode($daodien->attributes);
			$objPhim  = new ObjPhim();
			$objPhim->getObject($value['id']);
			$objPhim->id_dd  = [
				'id' => $daodien->id,
				'name' => $daoDienAttr->name,
				'slug' => $daodien->slug,
			];
			$objPhim->id_tl = $theloai->name;
			array_push($phimsReturn, $objPhim); 
		}
		//var_dump($phimsReturn);exit;
		return $phimsReturn;
	}

}
