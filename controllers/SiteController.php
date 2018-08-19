<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\form\LoginForm;
use app\models\EntryForm;
use app\models\form\SignupForm;
use app\models\User;
use yii\db\Query;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','profile','test-web'],
                'rules' => [
                    [
                        'actions' => ['logout','test-web','profile'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],   
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    public function actionTestWeb()
    {
        print_r('abc abc');
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    $session = Yii::$app->session;
                    $session->addFlash('flashMessage');
                    $session->setFlash('flashMessage', 'You have successfully registered!');
                    return $this->goHome();
                }
            }
        }
        return $this->render('signup',[
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    
    public function actionProfile()
    {
        $model = User::findIdentity(Yii::$app->user->identity->id);
        if ($model->load(Yii::$app->request->post())) {
            $model->birthDate = date('Y-m-d', strtotime($_POST['User']['birthDate']));
            if ($model->save()) {
                $session = Yii::$app->session;
                $session->addFlash('flashMessage');
                $session->setFlash('flashMessage', 'Cập nhật thành công !');
                return $this->redirect(['site/profile']);
            }
        }
        return $this->render('profile', [
            'model' => $model,
        ]);
    }

    
   
}
