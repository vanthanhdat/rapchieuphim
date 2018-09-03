<?php 
use yii\helpers\Html;
$this->title = 'Thêm lịch chiếu';
$rap = json_decode($dsPhong[0]->rap->attributes);
$this->params['breadcrumbs'][] = ['label' => 'Danh sách rạp', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $rap->name, 'url' => ['view','id' => $dsPhong[0]->rap->id]];
$this->params['breadcrumbs'][] = ['label' => 'Lịch chiếu', 'url' => ['lich-chieu','id' => $dsPhong[0]->rap->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
	<h2><?= Html::encode($this->title) ?></h2>
	<?= $this->render('_formlich', [
		'model' => $model,
		'dsPhong' => $dsPhong,
		'dsPhim' => $dsPhim
	]) ?>
</div>