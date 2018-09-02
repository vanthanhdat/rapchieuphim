<?php 
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = 'Lịch chiếu';
$this->params['breadcrumbs'][] = ['label' => 'Danh sách rạp', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $rap->name, 'url' => ['view','id' => $rap->id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">
	<h1><?= Html::encode($this->title) ?></h1>
	<p>
		<?= Html::a('Thêm lịch chiếu', ['create-lich'], ['class' => 'btn btn-success']) ?>
	</p>
	<?php 
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