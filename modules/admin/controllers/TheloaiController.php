<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Theloai;
use app\models\Phim;
use app\models\objects\ObjPhim;
use app\models\Daodien;
use app\models\search\TheloaiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;
use yii\db\Query;
use yii\data\Pagination;
/**
 * TheloaiController implements the CRUD actions for Theloai model.
 */
class TheloaiController extends Controller
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
                    'delete-phim' => ['POST'],
                    'disable-phim' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                   'class' => AccessRule::className(),
               ],
               'rules' => [
                [
                            // Allow full if user is admin
                   'actions' => ['index','create', 'update', 'delete','view','create-phim','delete-phim','view-phim','disable-phim'],
                   'allow' => true,
                   'roles' => [
                       User::ROLE_ADMIN
                   ],
               ],
           ],   
       ],
   ];
}

    /**
     * Lists all Theloai models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TheloaiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Theloai model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $pagination = new Pagination([
            'defaultPageSize' => 2,
            'totalCount' => count($model->phims),
        ]);    
        $listPhim = Phim::find()->where(['id_tl' => $id])
        ->orderBy(['status' => SORT_DESC])
        ->offset($pagination->offset)
        ->limit($pagination->limit)->all();
        return $this->render('view', [
            'model' => $model,
            'listPhim' => $listPhim,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Creates a new Theloai model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Theloai();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $session = Yii::$app->session;
            $session->addFlash('flashMessage');
            $session->setFlash('flashMessage', 'Thêm thành công !');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Theloai model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $session = Yii::$app->session;
            $session->addFlash('flashMessage');
            $session->setFlash('flashMessage', 'Cập nhật thành công !');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Theloai model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Theloai model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Theloai the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    protected function findModel($id)
    {
        if (($model = Theloai::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCreatePhim($id = 0)
    {
        $theloai = new Theloai();
        $model = new ObjPhim();
        $listDaoDien = Daodien::find()->all();
        $listTheLoai = [];
        if ($id == 0) {
            $listTheLoai = Theloai::find()->asArray()->all();
        }
        else{
            $theloai = $this->findModel($id);
            $model->id_tl = $id;
        }
        if ($model->load(Yii::$app->request->post()) ) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->createPhim()) {
                $session = Yii::$app->session;
                $session->addFlash('flashMessage');
                $session->setFlash('flashMessage', 'Thêm thành công !');
                return $this->redirect(['view', 'id' => $model->id_tl]);
            }
        }
        return $this->render('create-phim',[
            'theloai' => $theloai,
            'model' => $model,
            'listDaoDien' => $listDaoDien,
            'listTheLoai' => $listTheLoai,
        ]);
    }

    public function actionDeletePhim($id,$id_tl)
    {
        $objPhim = new ObjPhim();
        $phim = Phim::findOne($id);
        $attributes = json_decode($phim->attributes);
        $imagePhim = $attributes->image;
        if ($phim->status === 0) {
            if ($imagePhim !== '') {
                $pathFile = Yii::getAlias('@img').'/phim'.'/'.$imagePhim;
                $objPhim->deleteFile($pathFile);
            }
            if ($phim->delete()) {
                $session = Yii::$app->session;
                $session->addFlash('flashMessage');
                $session->setFlash('flashMessage', 'Đã xóa thành công phim "'.$attributes->title.'" !');
            }
        }
        else{
            $session = Yii::$app->session;
            $session->addFlash('errorMessage');
            $session->setFlash('errorMessage', 'Phim "'.$attributes->title.'" sắp chiếu hoặc đang được chiếu không thể xóa !');
        }              
        return $this->redirect(['view', 'id' => $id_tl]);
    }

    public function actionViewPhim($id)
    {
        $obj = new ObjPhim();
        $obj = $obj->getObject($id);
        $listDaoDien = Daodien::find()->all();
        $listTheLoai = Theloai::find()->asArray()->all();
        if ($obj->load(Yii::$app->request->post()) ) {
            $obj->image = UploadedFile::getInstance($obj, 'image');
            if ($obj->updatePhim($id)) {
                $session = Yii::$app->session;
                $session->addFlash('flashMessage');
                $session->setFlash('flashMessage', 'Cập nhật thành công !');
                return $this->redirect(['view-phim', 'id' => $id]);
            }
        }
        return $this->render('view-phim', [
            'model' => $obj,
            'listDaoDien' => $listDaoDien,
            'listTheLoai' => $listTheLoai,
        ]);
    }

    public function actionDisablePhim($id,$id_tl)
    {
        $query = new Query();
        $phim = Phim::findOne($id);
        $attributes = json_decode($phim->attributes);
        $check = $query->select(['id'])->from('lichchieu')->
        where(['>=','ngaychieu',date('Y-m-d')])->
        andWhere(['lichchieu.idphim' => $id])->all();
        $page = explode('page=',Yii::$app->request->referrer);
        $test = '';
        $test1 = '';
        if (empty($check) && $phim->status !== 1) {
            $phim->status = 0;
            if ($phim->save()) {
                $session = Yii::$app->session;
                $session->addFlash('flashMessage');
                $session->setFlash('flashMessage', 'Cập nhật ngưng chiếu phim "'.$attributes->title.'" thành công !');
            }
        }else{
            $session = Yii::$app->session;
            $session->addFlash('errorMessage');
            $session->setFlash('errorMessage', 'Phim "'.$attributes->title.'" thuộc phim sắp chiếu hoặc đang có lịch chiếu không thể xóa !');
        }
        return $this->redirect(['view', 'id' => $id_tl,'page' => $page[1]]);
    }
}
