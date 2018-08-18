<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\DemoWidget;
use dosamigos\datepicker\DatePicker;
$this->title='Registry';
$this->params['breadcrumbs'][] = $this->title;
?>
	
<div class="row">
	<div class="col-lg-6 col-lg-offset-3">
		<h1><?= Html::encode($this->title)?></h1>
		
		<?php $form = ActiveForm::begin(['id'=>'signup-form']); ?>
		<?= $form->field($model,'email')->textInput(['autofocus' => true])  ?>
		<?= $form->field($model, 'password')->passwordInput() ?>
		<?= $form->field($model, 'hoten') ?>
		<?= $form->field($model,'sdt') ?>
		<?= $form->field($model,'cmnd') ?>
		<?= $form->field($model, 'birthDate')->widget(
		    DatePicker::className(), [
		    'options' => ['autocomplete' => 'off'],		    		   			    			    		      	
		        'clientOptions' => [
		            'autoclose' => true,
		          	'format' => 'd-mm-yyyy',		  		         				
		            'endDate' => '-18Y',
		            'startDate' => '-55Y',
		        ]
		]);?>
		<?= $form->field($model, 'gender')->radioList(array(0=>'Nam',1=>'Nữ')); ?>
		<?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
		 <div class="form-group">
            <div class="col-lg-11">
                <?= Html::submitButton('Đăng ký', ['class' => 'btn btn-primary', 'name' => 'signup-button','id'=>'btnSignup']) ?>
            </div>
            
        </div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
