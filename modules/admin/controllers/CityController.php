<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\City;
use app\models\search\CitySearch;
use app\components\EventComponent;
use yii\web\Controller;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\base\Event;
use yii\db\Query;

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
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => ['delete' =>['post']],
        ],
    ];
}

public function beforeAction($action)
{
    $this->enableCsrfValidation = false;
    return parent::beforeAction($action);
}

    /**
     * Lists all Country models.
     * @return mixed
     */
    public function actionIndex()
    {
        //var_dump(Yii::$app->redis->keys('*'));

        //test cache
        /*$attributes = [
            'name' => 'van thanh dat','age' => 23, 'address' => 'cau chu y, quan 8', 'school' => 'huflit'
        ];
        Yii::$app->redis->hset('cache1','attributes',json_encode($attributes));
        /*$attributes1 = [
            'name' => 'nguyen nhut duy','age' => 21, 'address' => 'can giuoc, long an', 'school' => 'huflit'
        ];
        Yii::$app->redis->hset('cache1','attributes1',json_encode($attributes1));
        var_dump(Yii::$app->redis->hget('cache1','attributes'));
        var_dump(json_decode(Yii::$app->redis->hget('cache1','attributes')));

        var_dump(Yii::$app->redis->hget('cache1','attributes1'));
        var_dump(json_decode(Yii::$app->redis->hget('cache1','attributes1')));
        exit;
        // end test cache
        
        // test session
        
        /*
        $session = Yii::$app->session;
        var_dump($session['captcha']);exit;
        $session['captcha'] = [
            'number' => 5,
            'lifetime' => 3600,
            'tao-dat-ne' => 'thành đạt'
        ];
        var_dump($session['captcha']);
        exit;
         */

        // end test session
        
        $query = City::find();
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);
        return $this->render('index', [         
         'pagination' => $pagination
     ]);       
    }


    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionTestCreate()
    {
        $postData = file_get_contents('php://input');
        if ($postData !== '') {
            $dataObj = json_decode($postData);
            $city = new City();
            $city->cityname = $dataObj->data->cityname;
            $city->save();
        }
        else{
            throw new \yii\web\ForBiddenHttpException('Bạn không được vào đây !');
        }
    }

    public function actionTestUpdate()
    {
        $postData = file_get_contents('php://input');
        if ($postData !== '') {
            $dataObj = json_decode($postData);
            $city = City::findOne($dataObj->data->id);
            $city->cityname = $dataObj->data->cityname;
            $city->save();
        }
        else{
            throw new \yii\web\ForBiddenHttpException('Bạn không được vào đây !');
        }
    }

    public function actionTestDelete()
    {
        $postData = file_get_contents('php://input');
        if ($postData !== '') {
            $dataObj = json_decode($postData);
            $city = City::findOne($dataObj->data->id);
            $city->active = City::INACTIVE;
            if ($city->save()) {
                echo 'success';
            }
        }
        else{
            throw new \yii\web\ForBiddenHttpException('Bạn không được vào đây !');
        }
    }

    public function actionGetCities()
    {   
        $page = $_GET["page"] === 0 ? 1:$_GET["page"];
        $pageSize = 5;
        $query = City::find();
        $cities = $query->offset(($page-1)*$pageSize)->limit($pageSize)->where(['active' => City::ACTIVE])->orderBy(['cityname' => SORT_ASC])->asArray()->all();
        echo json_encode(['cities' => $cities]);
    }

    public function actionQueryCity()
    {
        $city = new City();
        $postData = file_get_contents('php://input');
        if ($postData !== '') {
            $obj = json_decode($postData);
            echo $city->queryCities($obj->params->queryParam,$obj->params->page);
        }
        else{
            throw new \yii\web\ForBiddenHttpException('Bạn không được vào đây !');
        }
    }

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


public function actionDelete($id)
{
   $this->findModel($id)->delete();    

   return $this->redirect(['index']); 
}




protected function findModel($id)
{
    if (($model = City::findOne($id)) !== null) {
        return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
}
}
