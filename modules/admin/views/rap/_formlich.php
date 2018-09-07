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
		<?php Pjax::begin(['id' => 'create-lich']);  ?>
		<?php $form = ActiveForm::begin(['layout' => 'inline','options' => ['data-pjax' => true]]); ?>
		<?= $form->field($model, 'phim')->dropDownList(Arrayhelper::map($listPhim,'id','title','status'),['prompt' => '-Chọn phim-']) ?>

		<?= $form->field($model, 'ngayChieu')->widget(
			DatePicker::className(), [
				'options' => ['autocomplete' => 'off',],		    		   			    			    		      	
				'clientOptions' => [
					'autoclose' => true,
					'format' => 'd-mm-yyyy',		  		         				
					'endDate' => '+14d',
					'startDate' => '+7d',
				]
			]);?>

		<?= $form->field($model,'gioChieu')->widget(
			TimePicker::className(),[
				'addonOptions' => [
					'asButton' => true,
				],
				'pluginOptions' => [
					'showSeconds' => false,
					'showMeridian' => false,
					'minuteStep' => 5,
				],
				'pluginEvents' => ['change' => "function(e) {  $('#objlichchieu-ngaychieu').trigger('change'); }"]
			]) ?>
			<?= $form->field($model, 'phong')->dropDownList(Arrayhelper::map([],'id','name'),['prompt' => '-Chọn phòng-']) ?>
			<div class="form-group">
				<br>
				<?= Html::submitButton('add', ['class' => 'btn btn-success']) ?>
			</div>
			<?php ActiveForm::end(); ?>
			<?php Pjax::end(); ?>
		</div>
	</div>