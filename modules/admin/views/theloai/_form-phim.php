<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Arrayhelper;
use dosamigos\datepicker\DatePicker;
use app\models\Phim;
 ?>

<div class='col-md-6'>
	    <?php $form = ActiveForm::begin([
    	'options' => ['enctype'=>'multipart/form-data']
    ]); ?>
	<?php $urlImage = Yii::getAlias('@web/uploads/image/phim'); ?>

	<img class="img-responsive" src="<?= $urlImage.'/'.$model->image ?>" id="imgPhim" alt="<?= $model->title ?>">

	<?= $form->field($model, 'image')->fileInput([
		'onchange' => 'readURL(this, "imgPhim")',
		'value' => $urlImage.'/'.$model->image,
	]) ?>
	

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model,'tomTat')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model,'nhaSanXuat') ?>

    <?= $form->field($model, 'thoiLuong') ?>
	
	<?= $form->field($model, 'trailerUrl')->widget(\yii\redactor\widgets\Redactor::className()) ?> 

    <?= $form->field($model,'quocGia') ?>

    <?= $form->field($model,'dienVien') ?>
	<?php
		if (!empty($listTheLoai)) {
		 	echo $form->field($model, 'id_tl')->dropDownList(Arrayhelper::map($listTheLoai,'id','name'),['prompt' => '-Chọn thể loại-']); 
		 } 
	 ?>
	<?php
		$authors = [];
		foreach ($listDaoDien as $key => $value) {
			$attributes = json_decode($value->attributes);
			$author = [
				'id' => $value->id,
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
		            'endDate' => '+60d',
		            'startDate' => '+15d',
		        ]
		]); ?>
	<?php if (Yii::$app->controller->action->id === 'view-phim') {
		//echo $form->field($model, 'status')->dropDownList(Arrayhelper::map(Phim::STATUS,'key','value'),['prompt' => '-Trạng thái-']); 
	} ?>	
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>