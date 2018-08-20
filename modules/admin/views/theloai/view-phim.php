<?php 
use yii\helpers\Html;
	$this->title = 'Update Phim: '.$model->title;
	$this->params['breadcrumbs'][] = ['label' => 'Danh mục phim'];
	$this->params['breadcrumbs'][] = ['label' => 'Quay lại','url' => ['view','id' => $model->id_tl]];
	//$this->params['breadcrumbs'][] = ['label' => $model->theloai];
?>
<div class="phim-form container">
	
	<h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form-phim', [
        'model' => $model,
        'listDaoDien' => $listDaoDien,
        'listTheLoai' => $listTheLoai,
    ]) ?>
</div>