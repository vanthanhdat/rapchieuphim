<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Daodien */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="daodien-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'attributes')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'quoctich')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
