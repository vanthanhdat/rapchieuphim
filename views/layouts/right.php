<?php 
use yii\db\Query;
$query = new Query();
$arr = $query->select(['id','attributes','status','slug'])->from('phim')->where(['status' => 2])
->limit(4)->orderBy(['created_at' => SORT_DESC])->all();
$urlImagePhim = Yii::getAlias('@web/uploads/image/phim');
?>

<section class="hidden-xs">
  <h3 class="text-uppercase">phim đang chiếu</h3>
  <div class="row movies-group">
    <?php foreach ($arr as $key => $value): ?>
      <?php  $attributes = json_decode($value['attributes']); ?>
      <div class="col-md-12 col-sm-12 col-xs-12 movie-item">
        <div class="article-movie-home">
          <img class="img-responsive" src="<?= $urlImagePhim.'/'.$attributes->image?>" style ="width:396px;height:264px;">
          <a href='/dat-ve/<?= $value['slug'] ?>'>
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
      <a href="/phim-hot/phim-dang-chieu" class="btn secondary fl-right">Xem thêm <span class="glyphicon glyphicon-arrow-right"></span></a>
    </div>
  </div>
</section>