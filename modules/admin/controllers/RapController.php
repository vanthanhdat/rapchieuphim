<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Rap;
use app\models\Phongchieu;
use app\models\City;
use app\models\objects\ObjRap;
use app\models\objects\ObjGia;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;
use yii\data\Pagination;
use yii\db\Query;

/**
 * RapController implements the CRUD actions for Rap model.
 */
class RapController extends Controller
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
                'rules' => [
                        [
                            // Allow full if user is admin
                           'actions' => ['index','create', 'update', 'delete','view','delete-phong','view-phong','create-phong'],
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
     * Lists all Rap models.
     * @return mixed
     */
    public function actionIndex()
    {      
        $query = Rap::find();
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $query->count(),
        ]);

        $listRap = $query->orderBy('id')
        ->offset($pagination->offset)
        ->limit($pagination->limit)->all();

        return $this->render('index', [
            'listRap' => $listRap,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Displays a single Rap model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
    
        $rap = Rap::findOne($id);
        $dsPhong = $rap->phongchieus;
        return $this->render('view', [
            'model' => $this->findModel($id),
            'listPhong' => $dsPhong,
        ]);
    }

    public function actionCreatePhong($id)
    {
        $query = new Query();
        $totalRooms = $query->select('COUNT(id)')->from('phongchieu')->where(['idrap' => $id])->scalar();
        $rulesRooms = $GLOBALS['_rules']['number_of_rooms_in_a_theater'];
        $objRap = $this->findModel($id);
        $model = new Phongchieu();
        if ($model->load(Yii::$app->request->post())) {
            if ((int)$totalRooms < (int)$rulesRooms) {
                $model->idrap = $id;
                $data = explode(',', trim($model->sodo));
                $arr = [];
                for ($i = 0; $i < count($data) ; $i++) {
                    array_push($arr,trim($data[$i]));
                }
                $model->sodo = json_encode($arr);
                if ($model->save()) {
                    $session = Yii::$app->session;
                    $session->addFlash('flashMessage');
                    $session->setFlash('flashMessage', 'Thêm thành công !');
                    return $this->redirect(['index-phong', 'id' => $model->id]);
                }
            }else{
                $session = Yii::$app->session;
                $session->addFlash('errorMessage');
                $session->setFlash('errorMessage', 'Rạp này đã đủ số lượng phòng cho phép, không được thêm nữa!');
                return $this->redirect(['view','id' => $id]);
            }
        }
        return $this->render('create-phong',[
            'rap' => $objRap,
            'model' => $model,
        ]);
    }

    public function actionViewPhong($id)
    {   
        $model = Phongchieu::findOne($id);
        $rap = Rap::findOne($model->idrap);
        if ($model->load(Yii::$app->request->post())) {
            $model->idrap = $model->idrap;
            $data = explode(',', trim($model->sodo));
            $arr = [];
            for ($i = 0; $i < count($data) ; $i++) {
                array_push($arr,trim($data[$i]));
            }
            $model->sodo = json_encode($arr);
            if ($model->save()) {
                $session = Yii::$app->session;
                $session->addFlash('flashMessage');
                $session->setFlash('flashMessage', 'Cập nhật thành công !');
                return $this->redirect(['view-phong',  'id' => $model->id]);
            }
        }
        return $this->render('view-phong',[
            'model' => $model,
            'rap' => $rap]);
    }

    public function actionDeletePhong($id)
    {
        $phong = Phongchieu::findOne($id);
        $idRap = $phong->idrap;
        if ($phong->delete()) {
            $session = Yii::$app->session;
            $session->addFlash('flashMessage');
            $session->setFlash('flashMessage', 'Đã xóa "'.$phong->name.'" thành công !');
        }
        return $this->redirect(['view','id' => $idRap]);
    }
    /**
     * Creates a new Rap model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {   

        $objGia = new ObjGia(null);
        $model = new ObjRap();
        $city = City::find()->asArray()->all();
        if ($model->load(Yii::$app->request->post())) {
            $id = $model->createRap(json_encode(Yii::$app->request->post('ObjGia')));
            $session = Yii::$app->session;
            $session->addFlash('flashMessage');
            $session->setFlash('flashMessage', 'Thêm thành công !');
            return $this->redirect(['view', 'id' => $id]);
        }
        return $this->render('create', [
            'model' => $model,
            'objGia' => $objGia,
            'listCity' => $city,
        ]);
    }

    /**
     * Updates an existing Rap model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $objGia = new ObjGia($model->gia);
        $city = City::find()->asArray()->all();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save(json_encode(Yii::$app->request->post('ObjGia')))) {
                $session = Yii::$app->session;
                $session->addFlash('flashMessage');
                $session->setFlash('flashMessage', 'Cập nhật thành công !');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'objGia' => $objGia,
            'listCity' => $city,
        ]);
    }

    /**
     * Deletes an existing Rap model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (Rap::findOne($id)->delete()) {
            $session = Yii::$app->session;
            $session->addFlash('flashMessage');
            $session->setFlash('flashMessage', 'Đã xóa "'.$model->name.'" thành công !');
        }
        return $this->redirect(['index']);
    }

    public function actionLichChieu()
    {
        
    }

    protected function findModel($id)
    {
        if (($model = Rap::findOne($id)) !== null) {
            $obj = new ObjRap();
            $obj->id = $model->id;
            $attributes = json_decode($model->attributes);
            $obj->name = $attributes->name;
            $obj->gia = json_decode($model->giave);
            $obj->description = $attributes->description;
            $obj->address = $attributes->address;
            $obj->phone = $attributes->phone;
            $obj->city_id = $model->idcity;
            $obj->created_at = $model->created_at;
            $obj->updated_at = $model->updated_at;
            return $obj;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
