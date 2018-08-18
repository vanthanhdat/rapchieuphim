<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
$this->title = 'Danh sách thể loại'; 
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' =>$searchModel, 
        'columns' => [
        ['class' => 'yii\grid\SerialColumn','header'=>"Số thứ tự"],
        'Id',
        'name',
        ['class' => 'yii\grid\ActionColumn','header'=>"Hành động"],
    ],       
    ]); ?>
</div>