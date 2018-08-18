<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
	$this->title = 'Thêm phòng chiếu';
	$this->params['breadcrumbs'][] = ['label' => 'Danh sách rạp', 'url' => ['index']];
	$this->params['breadcrumbs'][] = ['label' => $rap->name, 'url' => ['view','id' => $rap->id]];
	$this->params['breadcrumbs'][] = $this->title;
 ?>

 <div class="row">
 	<div class="col-md-6 col-md-offset-3">
 		<h1><?= Html::encode($this->title) ?></h1>
	 	<?php $form = ActiveForm::begin(); ?>

	 	<?= $form->field($model, 'name') ?>
		
		<div class="form-group" style="text-align: center;background-color: #3c8dbc;color: white;"><b>Screen</b></div><br>

	    <?= $form->field($model,'sodo')->textArea(['rows' => 15]) ?>
	
	    <div class="form-group">
	        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
	    </div>
	 	<?php ActiveForm::end(); ?>
 		<b>Chú thích:</b>
 		<p><strong>_</strong> đại diện chỗ trống trong phòng.</p>
 		<p><strong>các chữ cái</strong> đại diện các ghế</p>
 		<p>Các hàng ghế được ngăn cách bằng dấu <strong>","</strong> .</p>
 	</div>
 </div>