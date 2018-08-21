<?php

/* @var $this yii\web\View */

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

<div class="container"></div>

<div class="container"></div>
