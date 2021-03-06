<?php
$params = require __DIR__ . '/params.php';
Yii::setAlias('@img', realpath(dirname(__FILE__).'/../web/uploads/image/'));
$_holidays = ['01/01','30/04','01/05','2/9','10/3'];
$_rules = [
    'number_of_rooms_in_a_theater' => 5,
    'number_of_cinemas_in_a_city' => 5,
];

$_custom = [
    '12' => ['site','phim-dang-chieu','phim-sap-chieu'],
    '8-4' =>['']
];



//$db = require __DIR__ . '/db.php';
$container = new \yii\di\Container;

$container->set('db',[
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=demoyii',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
]);

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'container' => [
        /*
         'definitions' => [
            'yii\widgets\LinkPager' => ['maxButtonCount' => 7],
        ],
         */

    ],
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [

        /*
        'view' => [
             'theme' => [
                 'pathMap' => [
                    '@app/views'=>'@dixonsatit/agencyTheme/views',
                 ],
             ],
        ],
         */
        'eventCustom' => [
            'class' => 'app\components\EventComponent',
            'on demoEvent' => ['app\components\EventComponent','testEvent'],
            'on demoEvent1' => ['app\components\EventComponent','testEvent1'],    
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ZN28qJQW2gFpBJ53TJwdC7F1om059-Ml',
        ],
        /*'cache' => [
            'class' => 'yii\caching\FileCache',
        ],*/
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
        'cache' => [
            'class' => 'yii\redis\Cache',
        ],
        'session' => [
            'class' => 'yii\redis\Session',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'enableSession' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $container->get('db'),

        'urlManager' => [
           'enablePrettyUrl' => true,
           'showScriptName' => false,
           'normalizer' =>[
            'class' => 'yii\web\UrlNormalizer',
            'collapseSlashes' => true,

        ],
        'rules' => [
            '' => 'site/index',
                //site
            ['pattern' => 'profile','route' => '/site/profile','suffix' => '.html'],
            ['pattern' => 'login','route' => '/site/login','suffix' => '.html'],
            ['pattern' => 'register','route' => '/site/signup','suffix' => '.html'],
                //end site
                //
                //dao diễn
            ['pattern' => 'dao-dien','route' => 'daodien/index',],
            ['pattern' => 'dao-dien/<slug>','route' => 'daodien/view','suffix' => '.html'],

            // phim //
            ['pattern' => 'phim-hot/<slug>','route' => 'phim/index'], 
            ['pattern' => 'dat-ve/<slug>','route' => 'phim/view',], 

        ],
    ],
    'assetManager' => [
        'appendTimestamp' => true,
            /* test 
                'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,   // do not publish the bundle
                    'js' => [
                        '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
                    ]
                ],
            ],
             */           
        ],
    ],
    'modules' => [
      'redactor' => 'yii\redactor\RedactorModule',
      'admin' => [
        'class' => 'app\modules\admin\Module',
        'layout' => 'main',
    ]
],
'params' => [
    'thumbnail.size' => [128, 128],
    'time_start_end' => [
        'start'=>'9:00',
        'end' => '23:00'],
        'date-add' => [
            'startDate' => '7',
            'endDate' => '14'
        ]
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
