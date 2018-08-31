<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;
use yii\bootstrap\Tabs;
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<?php
			$urlImagePhim = Yii::getAlias('@web/uploads/image/phim');
			$arrPhim = [];
			foreach ($listPhim as $key) {
				$content = '<div class="col-md-3 col-sm-3 col-xs-6 movie-item">
				<div class = "article-movie-home">
				<img class="img-responsive" src="'.$urlImagePhim."/".$key['image'].'">
				<a href="/dat-ve/'.$key['slug'].'">
				<div class="overlay">
				<div class="movies-content">
				<div class="group">
				<div class="btn secondary-white">mua vé</div>
				</div>
				</div>
				</div>
				</a>
				</div>
				<div class="title-movie"><h4>'.$key['title'].'</h4></div>    
				</div>';  
				array_push($arrPhim, $content);
			}
			$tab = [
				'phim-dang-chieu' =>
				[
					'label' => 'Phim đang chiếu',
					'url' => ['/phim/index','slug' => 'phim-dang-chieu',],
				],
				'phim-sap-chieu' =>
				[
					'label' => 'Phim sắp chiếu',
					'url' => ['/phim/index','slug' => 'phim-sap-chieu',],
				]
			];
			$tab[$slug]['content'] = '<div class="movies-group">'.implode(' ',$arrPhim).'</div>';
			$tab[$slug]['active'] = true;
			$tab[$slug]['options'] = ['class' => 'animated fadeInUp','data-animate' => 'fadeInUp'];
			echo Tabs::widget([
				'items' => $tab,
			]);
			
			?>
		</div>
	</div>

</div>
