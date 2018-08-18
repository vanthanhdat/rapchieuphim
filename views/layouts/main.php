<?php

/* @var $this \yii\web\View */
/* @var $content string */

//use kartik\alert\Alert;
use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Demo-Yii-Basic',
        'brandUrl' => ['/site/index'],
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    
     $query = (new \yii\db\Query())
            ->select(['id', 'attributes','quoctich'])
            ->from('daodien')
            ->where(['id' => 1])
            ->one();
     $testjson = json_decode($query['attributes']);

    $navItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'City', 'url' => ['/city/index']],
        ['label' =>'signup'/*.$testjson->name*/, 'url' => ['/site/signup'],'visible' => Yii::$app->user->isGuest],
        ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
    ];
      if (!Yii::$app->user->isGuest) {
            array_push($navItems,['label' => Yii::$app->user->identity->hoten, 'url' => ['/site/profile']],
                /*
                this is a form
                 */
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    '<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'          
        );
      }
    echo Nav::widget([
      //  'activateItems' => false,
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $navItems,
    ]);

    NavBar::end();
    ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <?php     
             if (Yii::$app->session->getFlash('flashMessage') != null) {
                echo Alert::widget([
                    'options' => ['class' => 'alert-success'],
                    'body' => Yii::$app->session->getFlash('flashMessage'),
                ]);
            }
         ?>  
         <?= $content ?>           
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>       
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
