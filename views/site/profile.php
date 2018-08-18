<?php 
use yii\helpers\Html;
$this->title='THÔNG TIN KHÁCH HÀNG';
?>

<div class="update-user">
	<h1 style="text-align: center"><?= Html::encode($this->title) ?></h1>
	<?= $this->render('_form',[
        'model' => $model,
    ]) ?>
</div>