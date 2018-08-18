<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\City;
use app\models\CitySearch;
use app\components\EventComponent;
use yii\web\Controller;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\base\Event;

/**
 * CountryController implements the CRUD actions for Country model.
 */
class CityController extends Controller
{
    /**
     * {@inheritdoc}
     */
    
    const DEMO_EV = 'demoEvent';

    public function behaviors()
    {
        return [
            
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['create', 'update','index','download'],
                'rules' => [

                    // deny all POST requests
                   /* [
                        'allow' => false,
                        'verbs' => ['POST'],
                   ],*/
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => ['delete' =>['post']],
            ],
        ];
    }

    /**
     * Lists all Country models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new CitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       // $userHost = Yii::$app->request->userHost;
       // $userIP = Yii::$app->request->userIP;
      //  var_dump($userIp);        
        return $this->render('index', [         
           'dataProvider' => $dataProvider,'searchModel' => $searchModel,//'session' => $session,
        ]);       
    }

   

    /**
     * Displays a single Country model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Country model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {   
       // Yii::$app->eventCustom->trigger(EventComponent::EVENT_DEMO1);
        $model = new City();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $session = Yii::$app->session;
            $session->addFlash('flashMessage');
            $session->setFlash('flashMessage', 'Thêm thành công !');
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDownload()
    {
        $path = Yii::getAlias('@webroot/files');
         if (!is_file("$path/Hello.txt")) {
             throw new \yii\web\NotFoundHttpException('Không tìm thấy file !');
         }
        return Yii::$app->response->sendFile("$path/Hello.txt");
    }
    /**
     * Updates an existing Country model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Country model.
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
     * Finds the Country model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Country the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = City::findOne($id)) !== null) {
           // var_dump($model->raps);exit;
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
