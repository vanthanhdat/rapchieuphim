<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

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
		'dsPhim' => $dsPhim,
		//'dsPhong' => $dsPhong,
	]) ?>

	<?php Pjax::begin(['id' => 'lich-chieu'])  ?>
	<?php
	$idRap = $rap->id;
	$this->registerJs(
		'
		$(".view-selected-seats").click(function (){
        $.get($(this).attr("href"), function(data) {
        	//alert(data);
          $("#modal").modal("show").find("#modalContent").html(data)
       });
       return false;
    });
		$("document").ready(function(){ 
			$("#create-lich").on("pjax:end", function() {
				$.pjax.reload({container:"#lich-chieu"});	
				});
				$("#lichchieu-ngaychieu").change(function(){
					$.post("get-phong",{idRap:'.$idRap.',ngayChieu: $("#lichchieu-ngaychieu").val(),gioChieu:$("#lichchieu-giochieu").val()},function(data){
						var data = $.parseJSON(data);
						$("#lichchieu-idphong").empty();
						var options = "";
						if(data.length > 0){
							for(i = 0; i < data.length;i++){
								options += "<option value ="+data[i].id+">"+data[i].name+"</option>";
							}
						}
						else{
							options = "<option value>-Hết phòng-</option>";
						}
						$("#lichchieu-idphong").append(options);
						})});
					});'
				);
				?>
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
						[
							'header'=>"Các ghế đã được chọn",
							'class' => 'yii\grid\ActionColumn',
							'template' => '{selected-seat}',  
							'buttons' => [
								'selected-seat' => function($url, $model, $key) {   
									return Html::a($model->phong->name, [Url::current()], ['class' => 'btn btn-primary view-selected-seats']);
								}
							]
						],
						'gia',
						['class' => 'yii\grid\ActionColumn','header'=>"Hành động"],
					],'tableOptions' => ['class' => 'table table-bordered table-hover table-striped'], 
				]); ?>
				<?php Pjax::end() ?>
			</div>
			<?php 
			Modal::begin([
				'header' => 'test',
				'id' => 'modal',
			]);

			echo '<div id="modalContent">
			<p>Hello abc</p>
			</div>';

			Modal::end();
			?>