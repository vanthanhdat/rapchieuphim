<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\LinkPager;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\models\Country */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Danh mục phim',]; 
$this->params['breadcrumbs'][] = ['label' => 'Danh sách các thể loại','url' => 'index'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
 <div class="col-md-6">
    <h1><?= Html::encode($this->title) ?></h1>
    <h3>Mã thể loại: <?= Html::encode($model->id) ?></h3>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Thêm phim', ['/admin/theloai/create-phim','id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
    <h2>Danh sách các phim: <?php echo $model->name; ?></h2>

    <?php foreach ($listPhim as $key => $value): ?>
     <?php $attributes = json_decode($value->attributes); ?>
     <div class="list-group">
        <a href="<?= '/admin/theloai/view-phim/?id='.$value->id.'' ?>" title="<?= $attributes->title ?>" class="list-group-item list-group-item-action list-group-item-info">
         <?= Html::encode($attributes->title) ?> 
         [<?php foreach ($value::STATUS as $status => $value1): ?>
            <?= Html::encode($value1['key'] == $value->status ? $value1['value']:'') ?>
            <?php endforeach ?>]
        </a>
        <br>
        <?= Html::a('Xóa '.'<i class = "fa fa-trash"></i>', ['delete-phim', 'id' => $value->id,'id_tl' =>$model->id ], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => 'Bạn có muốn xóa phim này, sau khi xóa mọi dữ liệu liên quan đến bộ phim này sẽ bị mất, chẳng hạn như lịch chiếu, lưu ý ?',
                'method' => 'post',
            ],
        ]) ?> 
        <?= $value->status !== 0 ? Html::a('Ngưng chiếu '.'<i class = "fa fa-power-off"></i>', ['disable-phim', 'id' => $value->id,'id_tl' =>$model->id ], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Bạn có muốn ngưng chiếu phim này ?',
                'method' => 'post',
            ],
        ]):'' 
        ?>
    </div>    
<?php endforeach ?>
<?= LinkPager::widget([
    'pagination' => $pagination,
]) ?>
</div>
</div>
