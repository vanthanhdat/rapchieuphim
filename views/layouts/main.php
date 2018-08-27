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
$urlImage = Yii::getAlias('@web/uploads/img'); 
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
            <div class="col-xs-6 col-sm-8 col-md-8">
                <a href="/">
                    <img src="<?= $urlImage.'/'.'galaxy-logo.png' ?>" alt="Galaxy Cinema" class ="hidden-xs hidden-sm">
                    <img src="<?= $urlImage.'/'.'galaxy-logo-mobile.png' ?>" alt="Galaxy Cinema" class ="hidden-lg hidden-md">  
                </a>
            </div>

            <div class="col-xs-6 col-sm-4 col-md-4" >
                <ul class="menu">
                    <?php if (Yii::$app->user->isGuest): ?> 
                        <?php //data-toggle="modal" data-target="#login-modal" ?>
                        <li>
                            <a href="/login" >Login</a>
                        </li>
                        <span>|</span>
                        <li><a href="/register">Register</a>
                        </li>
                        <?php else: ?>
                            <li>
                                <a href="/profile" style="text-transform: uppercase;"><?= Yii::$app->controller->id //Yii::$app->user->identity->hoten ?></a>
                            </li>
                            <span>|</span>
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
        <?php NavBar::begin([
            'options' => ['class' =>'navbar-inverse','style'=>['margin-bottom' => 0]],
        ]);
        $navItems = [
            ['label' => 'Mua vé', 'url' => ['/site/index']],
            ['label' => 'City', 'url' => ['/thanh-pho']],
            ['label' => 'Phim', 'url' => ['#'],'items' => [
                ['label' => 'ABC', 'url' => '#'],
                ['label' => 'DEF', 'url' => '#'],
            ],],
            ['label' => 'GÓC ĐIỆN ẢNH','url' => '#','items' => [
             ['label' => 'Thể loại phim', 'url' => '#'],
             ['label' => 'Đạo diễn', 'url' => '/dao-dien'],
             ['label' => 'bình luận phim', 'url' => '#'],
             ['label' => 'blog điện ảnh', 'url' => '#'],
         ],],
         ['label' => 'Rạp', 'url' => ['/site/about']],
         ['label' => 'phim hay trong tháng', 'url' => ['/site/about']],
         '<div class="navbar-collapse collapse in col-sm-4 col-md-4">
         <form class="navbar-form">
         <div class="input-group">
         <input type="text" class="form-control" placeholder="Search">
         <span class="input-group-btn">
         <button type="submit" class="btn"><i class="fa fa-search"></i></button>
         </span>
         </div>
         </form>
         </div>'
     ];
     echo Nav::widget([
        'activateItems' => false,
        'options' => [
            'class' => 'navbar-nav navbar-inverse',
            'data-hover' => 'dropdown',
            'data-animations' => 'fadeInDown'],
        'items' => $navItems,
    ]);
    NavBar::end();?>
    <div class="container">
        <?php     
        if (Yii::$app->session->getFlash('flashMessage') != null) {
            echo Alert::widget([
                'options' => ['class' => 'alert-success'],
                'body' => Yii::$app->session->getFlash('flashMessage'),
            ]);
        }
        ?>  
        <!--Breadcrumbs-->
        <?php echo Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>             
    </div> 
    <div class="wrap">
        <?php $custom =$GLOBALS['_custom']; ?>
        <?php if (!in_array(Yii::$app->controller->id, $custom['12'])): ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?= $content ?>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?= $this->render('right.php')?>
                    </div>
                </div>
            </div>
            <?php else: ?>
                <?= $content ?>
            <?php endif ?>
            
            <?php if (Yii::$app->controller->action->id =='index'): ?>
                <div class="container">
                <div class="row">
                    introduce....
                </div>
            </div>
            <?php endif ?>
        </div>
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
