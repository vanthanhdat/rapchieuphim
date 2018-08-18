<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;
/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                       'class' => AccessRule::className(),
                   ],
              //  'only' => ['index'],
                'rules' => [
                    [
                            // Allow full if user is admin
                           'actions' => ['index'],
                           'allow' => true,
                           'roles' => [
                               User::ROLE_ADMIN
                           ],
                       ],
                ],   
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}
