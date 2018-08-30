<?php

namespace app\controllers;
use app\models\Phim;
use app\models\objects\ObjPhim;
class PhimController extends \yii\web\Controller
{
	public function actionIndex($slug)
	{	
		$listPhim = $this->getListPhimBySlug($slug);
		return $this->render('index',[
			'listPhim' => $listPhim,
		]);
	}

	protected function getListPhimBySlug($slug)
	{
		$param = -1 ;
		foreach (Phim::STATUS as $key => $value) {
			if (count($value) > 2) {
				if ($value['slug'] == $slug) {
					$param = $value['key'];
				}
			}   
		}
		if ($param > 0) {
			$listPhim  = Phim::find()->where(['status' => $param])->orderBy(['created_at' => SORT_DESC])->all();
			$returnList = [];
			foreach ($listPhim as $key => $value) {
				$obj = new ObjPhim();
				array_push($returnList, $obj->getObject($value['id']));
			}
			//var_dump($returnList);exit;
			return $returnList;
		}
		return false;
	}

}
