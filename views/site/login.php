<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Đăng nhập';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div class="row">
    <div class="col-lg-12 col-lg-offset-1">
        <h1><?= Html::encode($this->title)?></h1>  
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",           
            ],
        ]); ?>    
        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
        
        <?= $form->field($model, 'password')->passwordInput() ?>
        
        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>
        
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Login', ['class' => 'btn submit-button', 'name' => 'login-button','id'=>'btnLogin']) ?>
            </div>        
        </div>
    <?php ActiveForm::end(); ?>
    </div>
</div>
</div>
