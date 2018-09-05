<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$rap = $dsPhong[0]->rap;
$attributesRap = json_decode($rap->attributes);
$this->title = 'Lịch chiếu: '.$attributesRap->name;
$this->params['breadcrumbs'][] = ['label' => 'Danh sách rạp', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $attributesRap->name, 'url' => ['view','id' => $rap->id]];
$this->params['breadcrumbs'][] = 'Lịch chiếu';

?>
<div class="container">
	<h1>Thêm lịch chiếu</h1>
	<!--<p>
		<?= Html::a('Thêm lịch chiếu', ['create-lich','id' => $rap->id], ['class' => 'btn btn-success']) ?>
	</p>-->
	<?= $this->render('_formlich', [
		'model' => $model,
		'rap' => $rap,
		'dsPhim' => $dsPhim
	]) ?>

	<?php Pjax::begin(['id' => 'lich-chieu'])  ?>
	<?= GridView::widget([
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
			[
				'attribute' => 'ngaychieu',
				'value' => function ($model)
				{
					return $model::DAYS_OF_WEEK[date("l",strtotime($model->ngaychieu))].' '. date("d-m-Y",strtotime($model->ngaychieu));
				}
			],
			[
				'attribute' => 'giochieu',
				'value' => function ($model)
				{
					return date("H:i", strtotime($model->giochieu));
				}
			],
			'gia',
			'selected_seat',
			//['class' => 'yii\grid\ActionColumn','header'=>"Hành động"],
		],'tableOptions' => ['class' => 'table table-bordered table-hover table-striped'], 
	]); ?>
	<?php Pjax::end() ?>
</div>