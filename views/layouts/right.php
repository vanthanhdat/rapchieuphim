<?php 
use yii\db\Query;
$query = new Query();
$arr = $query->select(['id','attributes','status'])->from('phim')->where(['status' => 1])->limit(6)->all();
$urlImagePhim = Yii::getAlias('@web/uploads/image/phim');
?>

<section class="hidden-xs">
  <h3 style="text-transform: uppercase;">phim đang chiếu</h3>
  <div class="row movies-group">
    <?php foreach ($arr as $key => $value): ?>
      <?php  $attributes = json_decode($value['attributes']); ?>
      <div class="col-md-12 col-sm-12 col-xs-12 movie-item">
        <div class="article-movie-home">
          <img class="img-thumbnail img-responsive" src="<?= $urlImagePhim.'/'.$attributes->image?>" style ="width:396px;height:264px;">
          <a href='/dat-ve/<?= $value['id'] ?>'>
            <div class="decription-hover overlay">
              <div class="movies-content">
                <div class="group">
                  <div class="btn secondary-white">mua vé</div>
                </div>
              </div>
            </div>
          </a>
        </div>
        <div class="title-movie">
          <h4><?= $attributes->title ?></h4>
        </div>
      </div>
    <?php endforeach ?>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
      <a href="/phim-dang-chieu" class="btn secondary fl-right">Xem thêm</a>
    </div>
  </div>
</section>