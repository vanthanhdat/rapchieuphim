<?php 
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = 'Lịch chiếu'
?>
<div class="container">
	<h1><?= Html::encode($this->title) ?></h1>
	<p>
		<?= Html::a('Thêm lịch chiếu', ['create'], ['class' => 'btn btn-success']) ?>
	</p>
	<?php 
	//var_dump($dataProvider->getModels()[1]);exit;
	echo GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' =>$searchModel, 
		'columns' => [
			['class' => 'yii\grid\SerialColumn','header'=>"Số thứ tự"],
			'id',
			[	
				'attribute' => 'idphim',
				'value' =>  function ($model)
				{
					$phim = $model->phim;
					$attributes = json_decode($phim->attributes);
					return $attributes->title;
				}
			],
			[
				'attribute' => 'idphong',
				'value' => 'phong.name'
			],
			'ngaychieu',
			'giochieu',
			'gia',
			'selected_seat',
			['class' => 'yii\grid\ActionColumn','header'=>"Hành động"],
		],       
	]); ?>
</div>