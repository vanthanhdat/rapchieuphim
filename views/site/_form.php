<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\datepicker\DatePicker;
 ?>

 <div class="row">
	<div class="col-lg-6 col-lg-offset-3">	
		<?php $form = ActiveForm::begin(['id'=>'update-form']); ?>
		<?= $form->field($model,'email')->textInput(['autofocus' => true])  ?>
		<?= $form->field($model, 'hoten') ?>
		<?= $form->field($model,'sdt') ?>
		<?= $form->field($model,'cmnd') ?>
		<?= $form->field($model, 'birthDate')->widget(
		    DatePicker::className(), [
		    'options' => [
		    	'autocomplete' => 'off',
		    	'value' => date("d-m-Y", strtotime($model->birthDate)),
		    ],    		      	
		    'clientOptions' => [
	            'autoclose' => true,
	          	'format' => 'dd-mm-yyyy',		  		         				
	            'endDate' => '-18Y',
	            'startDate' => '-55Y',  
		        ],		       
		]);?>
		
		<?= $form->field($model, 'gender')->radioList([0 => 'Nam',1 => 'Nữ' ],[
		'item' => function($index, $label, $name, $checked, $value) {
        $checked = (Yii::$app->user->identity->gender == $value) ? 'checked' : '';
        $return = '<label class="radio-inline">';
        $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
        $return .= $label;
        $return .= '</label>';

        return $return;
    }]); ?>
		<?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
		 <div class="form-group">
            <div class="col-lg-11" style="bottom: 8px;">
                <?= Html::submitButton('Lưu thay đổi', ['class' => 'btn btn-danger', 'name' => 'update-button','id'=>'btnUpdate']) ?>
            </div>
            
        </div>
		<?php ActiveForm::end(); ?>
	</div>
</div>