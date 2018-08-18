<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
$this->title = 'Danh sách các tỉnh thành'; 
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="city-index container">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Demo download'.' '.'<span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>', ['download'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' =>$searchModel, 
        'columns' => [
        ['class' => 'yii\grid\SerialColumn','header'=>"Số thứ tự"],
        'id',
        'cityname',
        ['class' => 'yii\grid\ActionColumn','header'=>"Hành động"],
    ],       
    ]); ?>
</div>


