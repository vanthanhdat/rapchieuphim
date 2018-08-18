<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Daodien */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="daodien-form">

    <?php $form = ActiveForm::begin([
    	'options' => ['enctype'=>'multipart/form-data']
    ]); ?>
	
	<?php $urlImage = Yii::getAlias('@web/uploads/image/daodien'); ?>

	<img class="img-responsive" src="<?= $urlImage.'/'. $model->image ?>" id="imgDaoDien" alt="" style="width:254px;height:150px;">

	<?= $form->field($model, 'image')->fileInput([
		'onchange' => 'readURL(this, "imgDaoDien")'
	]) ?>

	<?= $form->field($model,'name')->textInput(['autofocus' => true])  ?>
	
	<?= $form->field($model, 'birthdate')->widget(
		    DatePicker::className(), [
		    'options' => ['autocomplete' => 'off',],		    		   			    			    		      	
		        'clientOptions' => [
		            'autoclose' => true,
		          	'format' => 'd-mm-yyyy',		  		         				
		            'endDate' => '-25Y',
		            'startDate' => '-70Y',
		        ]
		]);?>
	
	<?= $form->field($model, 'description')->widget(\yii\redactor\widgets\Redactor::className()) ?>

	<?= $form->field($model, 'tieusu')->widget(\yii\redactor\widgets\Redactor::className()) ?>

	<?= $form->field($model, 'quoctich') ?>
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
