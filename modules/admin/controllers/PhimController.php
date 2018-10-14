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
		$statusReturn = [];
		foreach (Phim::STATUS as $item => $status) {
			array_push($statusReturn,[
				'key' => $status['key'],
				'value' => $status['value'],
				'css' => $status['css']
			]);
		}
		return $this->render('index',[
            'status' => json_encode($statusReturn,JSON_UNESCAPED_UNICODE),
        ]);
	}

	public function actionGetPhims()
	{
		$status = $_GET["status"];
		$phims = Phim::find()->where(['status' => $status])
		//->orderBy(['created_at' => SORT_DESC])
		->all();
		return json_encode(['phims' => $this->returnPhims($phims)]);
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
			foreach (Phim::STATUS as $key => $value) {
				if ($value['key'] == $objPhim->status) {
					$objPhim->status = $value['value'];
				}
			}
			array_push($phimsReturn, $objPhim); 
		}
		//var_dump($phimsReturn);exit;
		return $phimsReturn;
	}

}
