<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$attributesRap = json_decode($rap->attributes);
$this->title = 'Lịch chiếu: '.$attributesRap->name;
$this->params['breadcrumbs'][] = ['label' => 'Danh sách rạp', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $attributesRap->name, 'url' => ['view','id' => $rap->id]];
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Lịch chiếu':['label' => 'Quay lại', 'url' => ['lich-chieu','idRap' => $rap->id]];

?>
<div class="container">
	<h2 class="text-uppercase"><?= $model->isNewRecord ? 'Thêm lịch chiếu' : 'Chỉnh sửa lịch chiếu' ?></h2>
	<?= $this->render('_formlich', [
		'model' => $model,
		'rap' => $rap,
		'dsPhim' => $dsPhim,
		'dsPhong' => $dsPhong,
	]) ?>

	<?php Pjax::begin(['id' => 'lich-chieu'])  ?>
	<?php
	$idRap = $rap->id;
	$this->registerJs(
		'
		$("#modal-selected-seat").on("hidden.bs.modal", function(){ 
			$(".seatCharts-row").remove();
			$(".seatCharts-legendList").remove();
			$("#seat-map").removeData("seatCharts");
			});
			$(".view-selected-seats").click(function (){ 
				$.get($(this).attr("href"), function(data) {
					var obj = JSON.parse(data);
					var firstSeatLabel = 1;
					var unavailable_seats = obj.selected_seats;	
					var arr = obj.sodo;
					sc = $("#seat-map").seatCharts({
						map: arr,
						naming : {
							top : false,
							getLabel : function (character, row, column) {
								return firstSeatLabel++;
								},
								},
								legend : {
									node : $("#legend"),
									items : [
									["a", "available",   "Còn trống"],
									["a", "unavailable", "Đã bán"],
									]                   
									},
									click: function () {
										if (this.status() == "unavailable") {                      
											return "unavailable";
										}
									}
									});
									sc.get(unavailable_seats).status("unavailable");
									$("#modal-selected-seat").modal("show");			
									});
									return false;
									});

									$("document").ready(function(){
										$("#details-lich").on("pjax:end", function() {
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
													'gia',
													[
														'header'=>"Các ghế đã được đặt",
														'class' => 'yii\grid\ActionColumn',
														'template' => '{selected-seat}',  
														'buttons' => [
															'selected-seat' => function($url, $model, $key) {   
																return Html::a($model->phong->name, ['selected-seat','id' => $key], ['class' => 'btn btn-primary view-selected-seats']);
															}
														]
													],
													[
														'class' => 'yii\grid\ActionColumn',
														'header'=>"Chi tiết",
														'template' => $model->isNewRecord?'{details-lich}':'{delete} ',
														'buttons' => $model->isNewRecord ? ['details-lich' => function($url, $model, $key) { 
															return Html::a('Xem', ['details-lich','id' => $key], ['class' => 'btn btn-primary','data-pjax'=> 0]);
													}
												]:[]  
											],
										],'tableOptions' => ['class' => 'table table-bordered table-hover table-striped'], 
									]); ?>
									<?php Pjax::end() ?>
								</div>
								<?php 
								Modal::begin([
									'header' => 'DANH SÁCH CÁC GHẾ ĐÃ ĐƯỢC BÁN',
									'id' => 'modal-selected-seat',
								]);

								echo '<div id="modalContent">
								<div id="seat-map">
								<div class="front-indicator" style = "margin-left:-137px;">
								<i class="fa fa-desktop fa-5x"></i>
								</div>
								</div>
								<p id="legend"></p>
								</div>';
								Modal::end();
								?>