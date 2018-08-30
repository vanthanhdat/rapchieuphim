<?php

namespace app\controllers;
use app\models\Phim;
use app\models\objects\ObjPhim;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class PhimController extends Controller
{

	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                       // 'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

	public function actionIndex($slug)
	{	
		$listPhim = $this->getListPhimBySlug($slug);
		return $this->render('index',[
			'listPhim' => $listPhim,
			'slug' => $slug
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
			return $returnList;
		}
		return false;
	}

}
