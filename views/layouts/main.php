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
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100' rel='stylesheet' type='text/css'>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div id="top">
    <div class="container animated fadeInDown" data-animate="fadeInDown" style="opacity: 0;">
        <div class="col-xs-6 col-sm-8 col-md-8 offer">
            <a href="/" class="btn btn-success" data-animate-hover="shake">Khiêm Chô galaxy</a>
        </div>
        <div class=" col-xs-6 col-sm-4 col-md-4" >
            <ul class="menu">
        <?php if (Yii::$app->user->isGuest): ?> 
                <li><a href="#" data-toggle="modal" data-target="#login-modal">Login</a>
                </li>
                <span style="color: white;">|</span>
                <li><a href="/site/signup">Register</a>
                </li>
        <?php else: ?>
                <li>
                    <a href="/site/profile" class="btn btn-primary" style="text-transform: uppercase;"><?= Yii::$app->user->identity->hoten ?></a>
                </li>
                <span style="color: white;">|</span>
                <?= '<li style= "padding-top:5px;">'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    '<span class="fa fa-sign-out " aria-hidden="true"></span>',
                    ['class' => 'btn logout']
                )
                . Html::endForm()
                . '</li>' ?>
        <?php endif ?>
             </ul>
        </div>
    </div>
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="Login">Đăng nhập</h4>
                </div>
                <div class="modal-body">
                    <form action="customer-orders.html" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" id="email-modal" placeholder="email">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="password-modal" placeholder="password">
                        </div>

                        <p class="text-center">
                            <button class="btn btn-primary"><i class="fa fa-sign-in"></i> Log in</button>
                        </p>
                    </form>
                    <p class="text-center text-muted">Not registered yet?</p>
                    <p class="text-center text-muted"><a href="register.html"><strong>Register now</strong></a>! It is easy and done in 1&nbsp;minute and gives you access to special discounts and much more!</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $urlImage = Yii::getAlias('@web/uploads/img'); ?>
    <div class="container">
            <?php     
             if (Yii::$app->session->getFlash('flashMessage') != null) {
                echo Alert::widget([
                    'options' => ['class' => 'alert-success'],
                    'body' => Yii::$app->session->getFlash('flashMessage'),
                ]);
            }
            ?>  
            <div class="navbar-collapse collapse right in">
                    <form class="navbar-form">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search">
                            <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                </div>
            <?php
            NavBar::begin([
            ]);
            $navItems = [
                ['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'City', 'url' => ['/city/index']],
                ['label' => 'About', 'url' => ['/site/about']],
            ];
            echo Nav::widget([
              //  'activateItems' => false,
                'options' => ['class' => 'navbar-nav'],
                'items' => $navItems,
            ]);
            NavBar::end();
            ?>
            <div class="row">
                <?php echo Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>   
            </div>  
    </div> 
    <?= $content ?>
    <br>
<div class="container" id = "footer">  
     <div id="footer" class="animated fadeInUp" data-animate="fadeInUp">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <h4>Pages</h4>
                    <hr class="hidden-md hidden-lg hidden-sm">
                </div>

                <div class="col-md-3 col-sm-6">
                    <h4>Pages</h4>
                    <hr class="hidden-md hidden-lg">
                </div> 

                <div class="col-md-3 col-sm-6">
                    <h4>Pages</h4>
                    <hr class="hidden-md hidden-lg">
                </div>

                <div class="col-md-3 col-sm-6">
                    <h4>Pages</h4>
                    <hr class="hidden-md hidden-lg">
                </div>
                

            </div>
        </div>
    </div>     
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
