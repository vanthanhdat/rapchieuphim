<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

	$this->title = 'Thêm phim';
	$this->params['breadcrumbs'][] = ['label' => 'Danh mục phim'];
	if ($theloai->name !== null) {
		$this->params['breadcrumbs'][] = ['label' => 'Thể loại','url' => ['index']];
		$this->params['breadcrumbs'][] = ['label' => $theloai->name, 'url' => ['view','id' => $theloai->id]];
	}
	else{
		
	}
	$this->params['breadcrumbs'][] = $this->title;
 ?>

<div class="phim-form container">
	<h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form-phim', [
        'model' => $model,
        'listDaoDien' => $listDaoDien,
        'listTheLoai' => $listTheLoai,
    ]) ?>
</div>