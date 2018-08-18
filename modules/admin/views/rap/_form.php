<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Arrayhelper;
/* @var $this yii\web\View */
/* @var $model app\models\Rap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rap-form container">

    <?php $form = ActiveForm::begin(); ?>
	
    <?= $form->field($model, 'name') ?>

    <?= $form->field($model,'address') ?>

    <?= $form->field($model,'phone') ?>
	
	<?= $form->field($model, 'description')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'city_id')->dropDownList(Arrayhelper::map($listCity,'id','cityname'),['prompt' => '-Chọn thành phố-']) ?>
    

    <?php foreach ($objGia->days as $key => $value): ?>
        <h4><label class="label label-primary" style="color: #3c8dbc;"><?php echo $value; ?></label></h4>
        <?= $form->field($objGia,''.$key.'_before') ?>
        <?= $form->field($objGia,''.$key.'_after') ?>
    <?php endforeach ?>
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
