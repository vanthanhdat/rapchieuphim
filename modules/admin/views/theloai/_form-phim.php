<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Arrayhelper;
use dosamigos\datepicker\DatePicker;
 ?>

<div class='col-md-6'>
	    <?php $form = ActiveForm::begin([
    	'options' => ['enctype'=>'multipart/form-data']
    ]); ?>
	<?php $urlImage = Yii::getAlias('@web/uploads/image/phim'); ?>

	<img class="img-responsive" src="" id="imgPhim" alt="" style="width:254px;height:150px;">

	<?= $form->field($model, 'image')->fileInput([
		'onchange' => 'readURL(this, "imgPhim")'
	]) ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model,'tomTat')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model,'nhaSanXuat') ?>

    <?= $form->field($model, 'thoiLuong') ?>

    <?= $form->field($model,'quocGia') ?>

    <?= $form->field($model,'dienVien') ?>
	<?php
		if (!empty($listTheLoai)) {
		 	echo $form->field($model, 'id_tl')->dropDownList(Arrayhelper::map($listTheLoai,'id','name'),['prompt' => '-Chọn thể loại-']); 
		 } 
	 ?>
	<?php
		$authors = [];
		foreach ($listDaoDien as $key) {
			$attributes = json_decode($key->attributes);
			$author = [
				'id' => $key->id,
				'name' => $attributes->name,
			];
			array_push($authors,$author);
		}
	 ?>	
	<?= $form->field($model, 'id_dd')->dropDownList(Arrayhelper::map($authors,'id','name'),['prompt' => '-Chọn đạo diễn-']); ?>
	<?= $form->field($model,'start')->widget(
		    DatePicker::className(), [
		    'options' => ['autocomplete' => 'off',],		    		   			    			    		      	
		        'clientOptions' => [
		            'autoclose' => true,
		          	'format' => 'd-mm-yyyy',		  		         				
		            'endDate' => '+30d',
		            'startDate' => '+15d',
		        ]
		]); ?>
 
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>