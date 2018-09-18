<?php

/* @var $this yii\web\View */

use yii\bootstrap\Tabs;

$this->title = 'Home-page';
$urlImage = Yii::getAlias('@web/uploads/img'); 
?>

<div id="main-carousel" class="carousel slide" data-ride = "carousel">
  <ol class="carousel-indicators hidden-sm hidden-xs">
    <li data-target="#main-carousel" data-slide-to="0" class="active"></li>
    <li data-target="#main-carousel" data-slide-to="1"></li>
    <li data-target="#main-carousel" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="item active">
      <img src="<?= $urlImage.'/'.'getinspired1.jpg' ?>" alt="Los Angeles" style="width:100%;">
    </div>

    <div class="item">
      <img src="<?= $urlImage.'/'.'main-slider2.jpg' ?>" alt="Chicago" style="width:100%;">
    </div>

    <div class="item">
      <img src="<?= $urlImage.'/'.'getinspired2.jpg' ?>" alt="New york" style="width:100%;">
    </div>
  </div>
  <a class="left carousel-control" href="#main-carousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#main-carousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <?php
      $urlImagePhim = Yii::getAlias('@web/uploads/image/phim');
      $phimDangChieu = [];
      foreach ($dangChieu as $key => $value) {
        $attributes = json_decode($value['attributes']);
        $contentSapChieu = '<div class="col-md-4 col-sm-4 col-xs-6 movie-item">
        <div class = "article-movie-home">
        <img class="item-home img-responsive" src="'.$urlImagePhim."/".$attributes->image.'">
        <a href="/dat-ve/'.$value['slug'].'">
        <div class="overlay">
        <div class="movies-content">
        <div class="group">
        <div class="btn secondary-white">mua vé</div>
        </div>
        </div>
        </div>
        </a>
        </div>
        <div class="title-movie"><h4>'.$attributes->title.'</h4></div>    
        </div>';  
        array_push($phimDangChieu, $contentSapChieu);
      }

      $phimSapChieu = [];
      foreach ($sapChieu as $key => $value) {
        $attributes = json_decode($value['attributes']);
        $contentSapChieu = '<div class="col-md-4 col-sm-4 col-xs-6 movie-item">
        <div class = "article-movie-home">
        <img class="item-home img-responsive" src="'.$urlImagePhim."/".$attributes->image.'">
        <a href="/dat-ve/'.$value['slug'].'">
        <div class="overlay">
        <div class="movies-content">
        <div class="group">
        <div class="btn secondary-white">mua vé</div>
        </div>
        </div>
        </div>
        </a>
        </div>
        <div class="title-movie"><h4>'.$attributes->title.'</h4></div>    
        </div>';  
        array_push($phimSapChieu, $contentSapChieu);
      }
      echo Tabs::widget([
        'items' => [
          [
            'label' => 'Phim đang chiếu',
            'content' => '  
            <div class="movies-group">
            '.implode(' ',$phimDangChieu).'
            </div>
            <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
            <a href="/phim-hot/phim-dang-chieu" class="btn secondary fl-right">Xem thêm</a>
            </div>
            </div>
            ',
            'active' => true,
            'options' => ['class' => 'animated fadeInUp','data-animate' => 'fadeInUp']
          ],
          [
            'label' => 'Phim sắp chiếu',
            'content' => '<div class="movies-group ">
            '.implode(' ',$phimSapChieu).'
            </div>
            <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
            <a href="/phim-hot/phim-sap-chieu" class="btn secondary fl-right">Xem thêm</a>
            </div>
            </div>',
                  //'headerOptions' => ['color' => 'yellow'],
            'options' => ['class' => 'animated fadeInUp','data-animate' => 'fadeInUp']
          ],
        ],
      ]); ?>
    </div>
  </div>

</div>

