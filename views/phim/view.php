<?php 
use yii\helpers\Html;

$attributes = json_decode($phim->attributes);
$this->title = $attributes->title;
$this->params['breadcrumbs'][] = ['label' => 'Đặt vé', 'url' => ['index','slug' => 'phim-dang-chieu']];
$this->params['breadcrumbs'][] = $this->title;
$urlImagePhim = Yii::getAlias('@web/uploads/image/phim');
?>

<section>
	<article>
		<div class="row">
			<div class="col-md-4 col-sm-12 col-xs-12">
				<div class="detail-img-order-ticket">
					<img class="img-responsive" src="<?= $urlImagePhim.'/'. $attributes->image ?>">
					<div class="play-button">
						<a href="#" data-toggle="modal" data-target="#modalTrailerPhim" class="btn"></a>
					</div>
				</div>
			</div>
			<div class="col-md-8 col-sm-12 col-xs-12">
				<h4><b>Phim:</b> <?= Html::encode($this->title) ?></h4>
				<h4><i class="fa fa-clock-o" aria-hidden="true"></i> : <?= $attributes->thoiluong ?> phút</h4>
				<div class="detail-info">
					<?php $daodien = json_decode($phim->dd['attributes']); ?>
					<p><b>Đạo diễn:</b> <?= $daodien->name  ?></p>
					<p><b>Diễn viên:</b> <?= $attributes->dienvien  ?></p>
					<p><b>Quốc gia:</b> <?= $attributes->quocgia  ?></p>
					<p><b>Nhà sản xuất:</b> <?= $attributes->nhasanxuat  ?></p>
					<p><b>Thể loại:</b> <?= $phim->tl['name']  ?></p>
					<p><b>Bắt đầu:</b> <?= $attributes->start  ?></p>
				</div>
			</div>
		</div>
	</article>
	<article>
		<h3 class="text-uppercase">Nội dung phim</h3>
		<div class="content-text">
			<?= $attributes->tomtat ?>
		</div>
	</article>
</section>

<?php $idUrl = explode('=', $attributes->trailerurl); ?>

<div class="modal fade" id="modalTrailerPhim" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><?= $attributes->title ?></h4>
			</div>
			<div class="modal-body">
				<div class="embed-responsive embed-responsive-16by9">
					<iframe id ='trailerVideo' class="embed-responsive-item" src="https://www.youtube.com/embed/<?= $idUrl[1] ?>" frameborder="0" allowfullscreen></iframe>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>