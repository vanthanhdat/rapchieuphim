<?php

namespace app\controllers;

use Yii;
use app\models\Daodien;
use app\models\objects\ObjDaoDien;
use app\models\DaodienSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\Pagination;
use yii\helpers\Url;
use app\models\Phim;

/**
 * DaodienController implements the CRUD actions for Daodien model.
 */
class DaodienController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $query = Daodien::find();
        $pagination = new Pagination([
            'defaultPageSize' => 6,
            'totalCount' => $query->count(),
        ]);
        $listDaoDien = $query->orderBy('id')->orderBy(['created_at' => SORT_DESC])
        ->offset($pagination->offset)
        ->limit($pagination->limit)->all();
        $data = ObjDaoDien::getListObject($listDaoDien);
        return $this->render('index',[
            'listDaoDien' => $data,
            'pagination' => $pagination]);
    }

    public function actionCreate()
    {
        $model = new ObjDaoDien();
        if ($model->load(Yii::$app->request->post())) {
            $model->image = UploadedFile::getInstance($model, 'image');
            $id = $model->createDaoDien();
            $session = Yii::$app->session;
            $session->addFlash('flashMessage');
            $session->setFlash('flashMessage', 'Thêm thành công !');
            return $this->redirect(['update', 'id' => $id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionView($slug)
    {  
      $model = $this->findModelBySlug($slug);
      $listPhim = Phim::find()->where(['id_dd' => $model->id])->all();
      return $this->render('view', [
        'model' => $model,
        'listPhim' => $listPhim,
    ]);
  }


  protected function findModel($id)
  {
    if (($model = Daodien::findOne($id)) !== null) {
        $obj = new ObjDaoDien();
        $obj->id = $model->id;
        $attributes = json_decode($model->attributes);
        $obj->name = $attributes->name;
        $obj->description = $attributes->description;
        $obj->birthdate = $attributes->birthdate;
        $obj->tieusu = $attributes->tieusu;
        $obj->image = $attributes->image;
        $obj->quoctich = $model->quoctich;
        $obj->created_at = $model->created_at;
        $obj->updated_at = $model->updated_at;
        return $obj;
    }
    throw new NotFoundHttpException('The requested page does not exist.');
}

protected function findModelBySlug($slug)
{

    if (($model = Daodien::findOne(['slug' => $slug])) !== null) {
        $obj = new ObjDaoDien();
        $obj->id = $model->id;
        $attributes = json_decode($model->attributes);
        $obj->name = $attributes->name;
        $obj->description = $attributes->description;
        $obj->birthdate = $attributes->birthdate;
        $obj->tieusu = $attributes->tieusu;
        $obj->image = $attributes->image;
        $obj->quoctich = $model->quoctich;
        $obj->created_at = $model->created_at;
        $obj->updated_at = $model->updated_at;
      /*  $data = json_decode(file_get_contents('https://api.ipdata.co?api-key=test'), true);
        var_dump($data);
        Yii::$app->params['abc'] = $data['ip'];
        var_dump(Yii::$app->params['abc']);
        exit;*/
        $model->updateCounters(['views' => 1]);
        $obj->views = $model->views;
        return $obj;
    } else {
        throw new NotFoundHttpException();
    }
}

}
