<?php

/* @var $this yii\web\View */

use yii\bootstrap\Tabs;

$this->title = 'Home-page';
$urlImage = Yii::getAlias('@web/uploads/img'); 
?>

<div id="main-carousel" class="carousel slide" data-ride = "carousel">
	   <ol class="carousel-indicators">
        <li data-target="#main-carousel" data-slide-to="0" class="active"></li>
        <li data-target="#main-carousel" data-slide-to="1"></li>
        <li data-target="#main-carousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
          <div class="item active">
            <img src="<?= $urlImage.'/'.'slider1.jpg' ?>" alt="Los Angeles" style="width:100%;">
          </div>

          <div class="item">
            <img src="<?= $urlImage.'/'.'slider2.jpg' ?>" alt="Chicago" style="width:100%;">
          </div>
        
          <div class="item">
            <img src="<?= $urlImage.'/'.'slider3.jpg' ?>" alt="New york" style="width:100%;">
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

        $dangChieu = [];
        $sapChieu = [];
        for ($i = 0; $i < 6; $i++) {
            $contentDangChieu = '<div class="col-md-4 col-sm-4 col-xs-6 movie-item">
                          <div class = "article-movie-home">
                            <img class="img-thumbnail img-responsive" src="'.$urlImagePhim."/"."the-meg-sieu-bao-chua.jpg".'">
                            <a href="/dat-ve/alpha">
                              <div class="decription-hover overlay">
                                <div class="movies-content">
                                  <div class="group">
                                    <div class="btn btn-warning">mua vé</div>
                                  </div>
                                </div>
                              </div>
                            </a>
                          </div>    
                        </div>';
            array_push($dangChieu, $contentDangChieu); 

            $contentSapChieu = '<div class="col-md-4 col-sm-4 col-xs-6 movie-item">
                                  <div class = "article-movie-home">
                                    <img class="img-thumbnail img-responsive" src="'.$urlImagePhim."/"."alpha1_1531975894329.jpg".'">
                                    <a href="/dat-ve/alpha">
                                      <div class="decription-hover overlay">
                                          <div class="movies-content">
                                            <div class="group">
                                                <div class="btn btn-warning">mua vé</div>
                                            </div>
                                          </div>
                                      </div>
                                    </a>
                                  </div>    
                                </div>';  
            array_push($sapChieu, $contentSapChieu);           
        }
        echo Tabs::widget([
          'items' => [
              [
                  'label' => 'Phim đang chiếu',
                  'content' => '  
                              <div class="row movies-group">
                                  '.implode(' ',$dangChieu).'
                              </div>
                              <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                                  <a href="/phim-dang-chieu" class="btn secondary fl-right">Xem thêm</a>
                                </div>
                              </div>
                                ',
                  'active' => true,
                  'options' => ['class' => 'animated fadeInUp','data-animate' => 'fadeInUp']
              ],
              [
                  'label' => 'Phim sắp chiếu',
                  'content' => '<div class="row movies-group ">
                                     '.implode(' ',$sapChieu).'
                                </div>
                              <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                                  <a href="/phim-dang-chieu" class="btn secondary fl-right">Xem thêm</a>
                                </div>
                              </div>',
                //  'headerOptions' => [''],
                  'options' => ['class' => 'animated fadeInUp','data-animate' => 'fadeInUp']
              ],
          ],
      ]); ?>
    </div>
  </div>

</div>

<div class="container"></div>
