<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Daodien;
use app\models\objects\ObjDaoDien;
use app\models\form\DaodienSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;
use yii\web\UploadedFile;
use yii\data\Pagination;
use yii\behaviors\TimestampBehavior;
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
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                       'class' => AccessRule::className(),
                   ],
               // 'only' => ['index','create', 'update', 'delete','view'],
                'rules' => [
                    [
                            // Allow full if user is admin
                           'actions' => ['index','create', 'update', 'delete','view'],
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
     * Lists all Daodien models.
     * @return mixed
     */
    public function actionIndex()
    {

        $query = Daodien::find();
        $pagination = new Pagination([
            'defaultPageSize' => 2,
            'totalCount' => $query->count(),
        ]);
        $listDaoDien = $query->orderBy(['created_at' => SORT_DESC])
        ->offset($pagination->offset)
        ->limit($pagination->limit)->all();
        $data = ObjDaoDien::getListObject($listDaoDien);
        return $this->render('index',[
            'listDaoDien' => $data,
            'pagination' => $pagination]);
    }


    /**
     * Creates a new Daodien model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
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


    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Daodien model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->image = UploadedFile::getInstance($model, 'image');  
            if ($model->save($model->image)) {
                return $this->redirect(['update', 'id' => $model->id]);
            }   
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Daodien model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {   $pathFile = '';
        $daodien = Daodien::findOne($id);
        $attributes = json_decode($daodien->attributes);
        $objDaoDien = new objDaoDien();
        if($attributes->image !== ''){
            $pathFile = Yii::getAlias('@img').'/daodien'.'/'.$attributes->image;
            if ($objDaoDien->deleteFile($pathFile)) {
                $daodien->delete();   
            }
        }
        else{
            $daodien->delete();
        }
        $session = Yii::$app->session;
        $session->addFlash('flashMessage');
        $session->setFlash('flashMessage', 'Đã xóa "'.$attributes->name.'" thành công!');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Daodien model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Daodien the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Daodien::findOne($id)) !== null) {
            $obj = new ObjDaoDien();
            $obj->id = $model->id;
            $obj->slug = $model->slug;
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
}
