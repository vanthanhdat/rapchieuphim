<?php 
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Arrayhelper;
use dosamigos\datepicker\DatePicker;
use kartik\time\TimePicker;
use yii\widgets\Pjax;
$listPhim = [];
foreach ($dsPhim as $key) {
	$attributes = json_decode($key->attributes);
	$arr = ['id' => $key->id,'title' => $attributes->title . ' (Ngày bắt đầu: '. $attributes->start.')','status' => $key::STATUS[$key->status]['value']];
	array_push($listPhim, $arr);
}
?>
<div class="row">
	<div class="col-md-12">
		<?php Pjax::begin(['id' => 'details-lich']);  ?>
		<?php $form = ActiveForm::begin(['layout' => 'inline','options' => ['data-pjax' => true]]); ?>
		<?= $form->field($model, 'idphim')->dropDownList(Arrayhelper::map($listPhim,'id','title','status'),['prompt' => '-Chọn phim-']) ?>

		<?= $form->field($model, 'ngaychieu')->widget(
			DatePicker::className(), [
				'options' => [
					'autocomplete' => 'off',
					'value' => $model->ngaychieu ? date("d-m-Y", strtotime($model->ngaychieu)):'',
				],		    		   			    			    		      	
				'clientOptions' => [
					'autoclose' => true,
					'format' => 'dd-mm-yyyy',		  		         				
					'endDate' => '+14d',
					'startDate' => '+7d',
				]
			]);?>

		<?= $form->field($model,'giochieu')->widget(
			TimePicker::className(),[
				'options' => [
					'readonly' => true,
					'autocomplete' => 'off'
				],
				'addonOptions' => [
					'asButton' => true,
				],
				'pluginOptions' => [
					'showSeconds' => false,
					'showMeridian' => false,
					'minuteStep' => 5,
				],
				'pluginEvents' => ['change' => "function(e) {  
					$.ajax({
						url: 'get-phong',
						type: 'post',
						data: {idRap: '".$rap->id."',ngayChieu: $('#lichchieu-ngaychieu').val(),gioChieu: $('#lichchieu-giochieu').val()},
						dataType: 'json',
						success: function(response){
							$('#lichchieu-idphong').empty();
							var options = '';
							if(response.length > 0){
								for(i = 0; i < response.length;i++){
									options += '<option value ='+response[i].id+'>'+response[i].name+'</option>';
								}
							}
							else{
								options = '<option value>-Hết phòng-</option>';
							}
							$('#lichchieu-idphong').append(options);
						}
						});
					}"]
				]) ?>
				<?= $form->field($model, 'idphong')->dropDownList(Arrayhelper::map($dsPhong,'id','name'),['prompt' => '-Chọn phòng-']) ?>

				<div class="form-group">
					<br>
					<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
				</div>

				<?php ActiveForm::end(); ?>
				<?php Pjax::end(); ?>
			</div>
		</div>