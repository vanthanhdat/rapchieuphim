<?php 
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	$attribute = json_decode($rap->attributes);
 ?>
 <?php $GLOBALS['_sodo'] = json_decode($model->sodo);
//$GLOBALS['_bookedSeats'] = ['10_8', '10_9', '10_10','10_11', '10_12', '10_13','10_14', '10_15'];
//$GLOBALS['_tickets'] = 2;
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Danh sách rạp', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $attribute->name, 'url' => ['view','id' => $rap->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
 <div class="container">
 	<p id="selected-seats">
      </p>
    <div id="seat-map" class="col-md-7">
    	<div class="front-indicator"><i class="fa fa-desktop fa-5x"></i></div>
    </div>
    <div class="col-md-5">
	 	<?php $form = ActiveForm::begin(); ?>

	 	<?= $form->field($model, 'name') ?>
		
		<div class="form-group" style="text-align: center;background-color: #3c8dbc;color: white;"><b>Screen</b></div><br>
		
	    <?= $form->field($model,'sodo')->textArea(['rows' => 15,'value' => implode(','."\n", json_decode($model->sodo))]) ?>

	    <div class="form-group">
	        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
	    </div>
	 	<?php ActiveForm::end(); ?>
	 	<div class="row">
	 		<b>Chú thích:</b>
	 		<p><strong>_</strong> đại diện chỗ trống trong phòng.</p>
	 		<p><strong>Các chữ cái</strong> đại diện các ghế</p>
	 		<p><strong>Các hàng ghế</strong> được ngăn cách bằng dấu <strong>","</strong> .</p>
	 	</div>
    </div>
 </div>
